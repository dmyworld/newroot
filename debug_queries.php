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

echo "--- Active Subscribers Query Debug ---\n";
$sql = "SELECT u.id, u.username, u.email, u.subscription_status, s.plan_id, s.activated_at, s.expires_at 
        FROM geopos_users u 
        LEFT JOIN tp_subscriptions s ON s.user_id = u.id 
        JOIN aauth_user_to_group ug ON ug.user_id = u.id 
        WHERE u.subscription_status = 'active' 
        AND ug.group_id IN (2, 8)";
$res = $conn->query($sql);
if (!$res) {
    echo "Error: " . $conn->error . "\n";
} else {
    echo "Rows found: " . $res->num_rows . "\n";
    while($row = $res->fetch_assoc()) {
        print_r($row);
    }
}

echo "\n--- Commissions Query Debug ---\n";
$sql_c = "SELECT c.*, u.username, u.email, i.tid, i.total, s.plan_id 
          FROM tp_commission_logs c 
          JOIN geopos_users u ON u.id = c.user_id 
          JOIN geopos_invoices i ON i.id = c.invoice_id 
          LEFT JOIN tp_subscriptions s ON s.user_id = u.id";
$res_c = $conn->query($sql_c);
if (!$res_c) {
    echo "Error: " . $conn->error . "\n";
} else {
    echo "Rows found: " . $res_c->num_rows . "\n";
}

$conn->close();
?>
