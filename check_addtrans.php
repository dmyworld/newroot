<?php
// Debug script to check addtrans logic
header('Content-Type: text/plain');
$host = 'localhost';
$user = 'root';
$pass = ''; 
$dbname = 'newroot';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Check Account ID 1 (Cash in Hand)
$sql = "SELECT id, holder, loc FROM geopos_accounts WHERE id = 1";
$res = $conn->query($sql);
$acc = $res->fetch_assoc();
echo "Account ID 1: " . json_encode($acc) . "\n";

// 2. Check User (assume user ID 1 for test)
$sql_u = "SELECT id, username, loc FROM geopos_employees WHERE id = 1";
$res_u = $conn->query($sql_u);
$user_data = $res_u->fetch_assoc();
echo "User ID 1: " . json_encode($user_data) . "\n";

// 3. Simulate Logic from addtrans
$pay_acc = 1;
$user_loc = $user_data['loc'];
$bdata = true; // Assume BDATA is true (usually true)

echo "Simulating addtrans check for acc $pay_acc at user loc $user_loc...\n";

$sql_find = "SELECT holder FROM geopos_accounts WHERE id = $pay_acc";
if ($user_loc > 0) {
    $sql_find .= " AND (loc = $user_loc OR loc = 0)";
}
$res_f = $conn->query($sql_find);
$found = $res_f->fetch_assoc();

if ($found) {
    echo "SUCCESS: Account found for this user/location: " . $found['holder'] . "\n";
} else {
    echo "FAILURE: Account NOT found for this user/location. Logic would return FALSE/NULL.\n";
}

$conn->close();
?>
