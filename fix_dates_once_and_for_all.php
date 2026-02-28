<?php
header('Content-Type: text/plain');
$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);

$server_today = date('Y-m-d');
echo "Server Today: $server_today\n";

// Update transactions that are Feb 12 or later
$sql = "UPDATE geopos_transactions SET date = '$server_today' WHERE date >= '2026-02-12'";
$conn->query($sql);
echo "Transactions Updated (>= Feb 12): " . $conn->affected_rows . "\n";

// Also update any transactions that have a timestamp later than now in any way
$sql = "UPDATE geopos_transactions SET date = '$server_today' WHERE date > '$server_today'";
$conn->query($sql);
echo "Remaining Future Updated: " . $conn->affected_rows . "\n";

$conn->close();
?>
