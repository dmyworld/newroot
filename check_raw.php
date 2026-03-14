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

echo "--- tp_commission_logs Raw ---\n";
$res = $conn->query("SELECT * FROM tp_commission_logs");
while($row = $res->fetch_assoc()) print_r($row);

echo "\n--- geopos_users Raw (ID 2) ---\n";
$res = $conn->query("SELECT id, username FROM geopos_users WHERE id = 2");
while($row = $res->fetch_assoc()) print_r($row);

echo "\n--- geopos_invoices Raw (ID 6) ---\n";
$res = $conn->query("SELECT id, tid FROM geopos_invoices WHERE id = 6");
while($row = $res->fetch_assoc()) print_r($row);

$conn->close();
?>
