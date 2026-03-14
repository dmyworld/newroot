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

$user_id = 2;
echo "Checking sales for User ID $user_id:\n";
$sql = "SELECT SUM(total) as total_sales FROM geopos_invoices WHERE user_id = $user_id";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
$total_sales = $row['total_sales'] ?? 0;
echo "Total Sales: $total_sales\n";
echo "Expected Commission (3%): " . ($total_sales * 0.03) . "\n";

echo "\nChecking paid commissions in tp_commissions:\n";
$sql = "SELECT SUM(commission_amount) as total_paid FROM tp_commissions WHERE user_id = $user_id AND status = 'paid'";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
$total_paid = $row['total_paid'] ?? 0;
echo "Total Paid: $total_paid\n";
echo "Outstanding: " . (($total_sales * 0.03) - $total_paid) . "\n";

$conn->close();
?>
