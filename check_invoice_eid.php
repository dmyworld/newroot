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

echo "Top 5 Invoices with their EID:\n";
$res = $conn->query("SELECT id, tid, total, eid FROM geopos_invoices LIMIT 5");
while($row = $res->fetch_assoc()) {
    echo "ID: " . $row['id'] . " | TID: " . $row['tid'] . " | Total: " . $row['total'] . " | EID: " . $row['eid'] . "\n";
}

$conn->close();
?>
