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

echo "--- Trace Step 1: tp_commission_logs -> geopos_users ---\n";
$sql1 = "SELECT c.id, c.user_id, u.username 
         FROM tp_commission_logs c 
         JOIN geopos_users u ON u.id = c.user_id";
$res1 = $conn->query($sql1);
echo "Result: " . ($res1 ? $res1->num_rows : "Error: ".$conn->error) . "\n";

echo "\n--- Trace Step 2: tp_commission_logs -> geopos_invoices ---\n";
$sql2 = "SELECT c.id, c.invoice_id, i.tid 
         FROM tp_commission_logs c 
         JOIN geopos_invoices i ON i.id = c.invoice_id";
$res2 = $conn->query($sql2);
echo "Result: " . ($res2 ? $res2->num_rows : "Error: ".$conn->error) . "\n";

echo "\n--- Trace Step 3: Full Query with LEFT JOINs ---\n";
$sql3 = "SELECT c.id, u.username, i.tid, s.plan_id 
         FROM tp_commission_logs c 
         LEFT JOIN geopos_users u ON u.id = c.user_id 
         LEFT JOIN geopos_invoices i ON i.id = c.invoice_id 
         LEFT JOIN tp_subscriptions s ON s.user_id = u.id";
$res3 = $conn->query($sql3);
echo "Result: " . ($res3 ? $res3->num_rows : "Error: ".$conn->error) . "\n";
while($row = $res3->fetch_assoc()) print_r($row);

$conn->close();
?>
