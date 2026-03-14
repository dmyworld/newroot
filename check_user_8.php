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

echo "User ID 8 Details:\n";
$res = $conn->query("SELECT id, username, email FROM geopos_users WHERE id = 8");
while($row = $res->fetch_assoc()) {
    echo "ID: " . $row['id'] . " | Username: " . $row['username'] . "\n";
}

$conn->close();
?>
