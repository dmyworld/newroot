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
echo "Verifying Logic for User ID $user_id (timberpro_owner):\n";

// 1. Get user loc
$res = $conn->query("SELECT loc FROM geopos_users WHERE id = $user_id");
$user = $res->fetch_assoc();
$loc = $user['loc'] ?? 0;
echo " - User Location ID: $loc\n";

// 2. Sum sales for this loc
$res = $conn->query("SELECT SUM(total) as total_sales FROM geopos_invoices WHERE loc = $loc");
$row = $res->fetch_assoc();
$total_sales = $row['total_sales'] ?? 0;
echo " - Total Sales for loc $loc: $total_sales\n";

// 3. Expected commission
$expected_commission = $total_sales * 0.03;
echo " - Expected Commission (3%): $expected_commission\n";

// 4. Paid so far
$res = $conn->query("SELECT SUM(commission_amount) as total_paid FROM tp_commissions WHERE user_id = $user_id AND status = 'paid'");
$row = $res->fetch_assoc();
$total_paid = $row['total_paid'] ?? 0;
echo " - Total Paid so far: $total_paid\n";

$outstanding = $expected_commission - $total_paid;
echo " - Net Outstanding: $outstanding\n";

$conn->close();
?>
