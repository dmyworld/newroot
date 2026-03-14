<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'c:/Users/user/Documents/GitHub/www/newroot/system/');
define('APPPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/');

require_once(APPPATH . 'config/database.php');
$config = $db['default'];

$conn = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT id, username, pass FROM geopos_users LIMIT 5");

while($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . " | User: " . $row['username'] . " | Pass: " . substr($row['pass'], 0, 10) . "... (Length: " . strlen($row['pass']) . ")\n";
}

$conn->close();
?>
