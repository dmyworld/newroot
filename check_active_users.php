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

$res = $conn->query("SELECT id, username, roleid, subscription_status FROM geopos_users WHERE subscription_status = 'active' LIMIT 10");
while($row = $res->fetch_assoc()) {
    echo "ID: " . $row['id'] . " | Name: " . $row['username'] . " | Role: " . $row['roleid'] . " | Status: " . $row['subscription_status'] . "\n";
}

$conn->close();
?>
