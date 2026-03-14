<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'c:/Users/user/Documents/GitHub/www/newroot/system/');
define('APPPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/');

require_once(APPPATH . 'config/database.php');
$db_config = $db['default'];

$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Connection failed");
}

echo "--- Full aauth_user_to_group Mapping ---\n";
$res = $conn->query("SELECT ug.user_id, ug.group_id, u.username, g.name as group_name 
                     FROM aauth_user_to_group ug 
                     LEFT JOIN geopos_users u ON u.id = ug.user_id 
                     LEFT JOIN aauth_groups g ON g.id = ug.group_id");
while($row = $res->fetch_assoc()) {
    echo "User: " . $row['username'] . " (ID: " . $row['user_id'] . ") | Group: " . $row['group_name'] . " (ID: " . $row['group_id'] . ")\n";
}

$conn->close();
?>
