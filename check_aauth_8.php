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

echo "Aauth User ID 8:\n";
$res = $conn->query("SELECT id, email FROM aauth_users WHERE id = 8");
while($row = $res->fetch_assoc()) {
    echo "ID: " . $row['id'] . " | Email: " . $row['email'] . "\n";
}

$conn->close();
?>
