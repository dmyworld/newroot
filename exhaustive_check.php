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

$res = $conn->query("SELECT * FROM aauth_groups");
while($row = $res->fetch_assoc()) {
    echo $row['id'] . ": " . $row['name'] . "\n";
}

echo "\n--- All Active Users in geopos_users ---\n";
$res = $conn->query("SELECT id, username, roleid FROM geopos_users WHERE subscription_status = 'active'");
while($row = $res->fetch_assoc()) {
    echo "ID: " . $row['id'] . " | Name: " . $row['username'] . " | RoleID: " . $row['roleid'] . "\n";
}

$conn->close();
?>
