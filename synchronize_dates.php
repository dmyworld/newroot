<?php
header('Content-Type: text/plain');
$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);

$server_today = date('Y-m-d');
echo "Server Today: $server_today\n";

// Update transactions that are in the "future"
$res = $conn->query("UPDATE geopos_transactions SET date = '$server_today' WHERE date > '$server_today'");
echo "Transactions Updated: " . $conn->affected_rows . "\n";

// Ensure all transactions have loc = 0 if they don't have one, or set them to match accounts
$conn->query("UPDATE geopos_transactions t JOIN geopos_accounts a ON t.acid = a.id SET t.loc = a.loc WHERE t.loc != a.loc");
echo "Transaction Loc Synced: " . $conn->affected_rows . "\n";

$conn->close();
?>
