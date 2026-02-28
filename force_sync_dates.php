<?php
header('Content-Type: text/plain');
$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);

$server_today = date('Y-m-d');
echo "Server Today: $server_today\n";

// Explicitly find Feb 12 transactions
$res = $conn->query("SELECT id FROM geopos_transactions WHERE date = '2026-02-12'");
echo "Feb 12 Transactions found: " . $res->num_rows . "\n";

$conn->query("UPDATE geopos_transactions SET date = '$server_today' WHERE date = '2026-02-12'");
echo "Updated to $server_today: " . $conn->affected_rows . "\n";

// Also fix any other future dates
$conn->query("UPDATE geopos_transactions SET date = '$server_today' WHERE date > '$server_today'");
echo "Other Future Updated: " . $conn->affected_rows . "\n";

$conn->close();
?>
