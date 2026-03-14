<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'c:/Users/user/Documents/GitHub/www/newroot/system/');
define('APPPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/');

require_once(APPPATH . 'config/database.php');
$db_config = $db['default'];

$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Connection failed\n");
}

echo "Checking Account ID 1:\n";
$res = $conn->query("SELECT * FROM geopos_accounts WHERE id = 1");
if ($row = $res->fetch_assoc()) {
    print_r($row);
} else {
    echo "Account ID 1 NOT found.\n";
}

$conn->close();
?>
