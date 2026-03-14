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

echo "timberpro_owner (ID 2) business_id: \n";
$res = $conn->query("SELECT business_id FROM geopos_users WHERE id = 2");
$row = $res->fetch_assoc();
$b_id = $row['business_id'] ?? 'NULL';
echo "Business ID: $b_id\n";

echo "\nCheck invoices for Business ID $b_id:\n";
if ($b_id !== 'NULL' && $b_id !== '') {
    $res = $conn->query("SELECT COUNT(*) as cnt, SUM(total) as total FROM geopos_invoices WHERE business_id = $b_id");
    $row = $res->fetch_assoc();
    echo "Count: " . $row['cnt'] . " | Total Sales: " . $row['total'] . "\n";
} else {
    echo "User 2 has no business_id. Checking if eid 2 is used in invoices instead.\n";
    $res = $conn->query("SELECT COUNT(*) as cnt, SUM(total) as total FROM geopos_invoices WHERE eid = 2");
    $row = $res->fetch_assoc();
    echo "Count (eid=2): " . $row['cnt'] . " | Total Sales: " . $row['total'] . "\n";
}

$conn->close();
?>
