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

$res = $conn->query("SELECT u.id, u.username, ug.group_id 
                     FROM geopos_users u 
                     JOIN aauth_user_to_group ug ON ug.user_id = u.id 
                     WHERE ug.group_id IN (2, 8)");
if (!$res) {
    echo "Query Error: " . $conn->error;
} else {
    while($row = $res->fetch_assoc()) {
        echo "ID: " . $row['id'] . " | Name: " . $row['username'] . " | GroupID: " . $row['group_id'] . "\n";
    }
}

$conn->close();
?>
