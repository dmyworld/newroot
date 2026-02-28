<?php
header('Content-Type: text/plain');
$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

echo "--- All Asset Accounts ---\n";
$res = $conn->query("SELECT id, holder, account_type, lastbal, loc FROM geopos_accounts WHERE account_type = 'Assets'");
while($row = $res->fetch_assoc()) {
    echo "ID: {$row['id']} | Holder: {$row['holder']} | Bal: {$row['lastbal']} | Loc: {$row['loc']}\n";
}

echo "\n--- All Income Accounts ---\n";
$res = $conn->query("SELECT id, holder, account_type, lastbal, loc FROM geopos_accounts WHERE account_type = 'Income'");
while($row = $res->fetch_assoc()) {
    echo "ID: {$row['id']} | Holder: {$row['holder']} | Bal: {$row['lastbal']} | Loc: {$row['loc']}\n";
}

echo "\n--- All Expense Accounts ---\n";
$res = $conn->query("SELECT id, holder, account_type, lastbal, loc FROM geopos_accounts WHERE account_type = 'Expenses'");
while($row = $res->fetch_assoc()) {
    echo "ID: {$row['id']} | Holder: {$row['holder']} | Bal: {$row['lastbal']} | Loc: {$row['loc']}\n";
}

$conn->close();
?>
