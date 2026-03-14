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

$res = $conn->query("SELECT id, tid, total FROM geopos_invoices LIMIT 1");
if ($row = $res->fetch_assoc()) {
    $inv_id = $row['id'];
    echo "Found Invoice ID: $inv_id (TID: " . $row['tid'] . ")\n";
    
    // Seed a log for user 2
    $conn->query("INSERT INTO tp_commission_logs (invoice_id, user_id, amount, payment_status, created_at) 
                  VALUES ($inv_id, 2, " . ($row['total'] * 0.03) . ", 'unpaid', NOW())");
    echo "Seeded commission log for User 2.\n";
} else {
    echo "No invoices found. Creating a dummy invoice...\n";
    $conn->query("INSERT INTO geopos_invoices (tid, total, status, i_class) VALUES (1001, 1000, 'paid', 0)");
    $inv_id = $conn->insert_id;
    $conn->query("INSERT INTO tp_commission_logs (invoice_id, user_id, amount, payment_status, created_at) 
                  VALUES ($inv_id, 2, 30, 'unpaid', NOW())");
    echo "Seeded dummy invoice and log for User 2.\n";
}

$conn->close();
?>
