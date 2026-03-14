<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'dummy');
include 'application/config/database.php';
$db_config = $db['default'];
$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "--- geopos_users STRUCTURE ---\n";
$res = $conn->query("DESCRIBE geopos_users");
while($row = $res->fetch_assoc()) {
    print_r($row);
}
?>
