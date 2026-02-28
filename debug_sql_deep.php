<?php
header('Content-Type: text/plain');
$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$start_date = date('Y-m-01');
$end_date = date('Y-m-d');
$loc = 0;

echo "--- Debugging Step by Step ---\n";

// 1. Transaction count
$res = $conn->query("SELECT COUNT(*) as cnt FROM geopos_transactions");
echo "Total Transactions: " . $res->fetch_assoc()['cnt'] . "\n";

// 2. Transaction filter test
$res = $conn->query("SELECT COUNT(*) as cnt FROM geopos_transactions WHERE credit > 0");
echo "Transactions with Credit > 0: " . $res->fetch_assoc()['cnt'] . "\n";

// 3. Join test
$res = $conn->query("SELECT COUNT(*) as cnt FROM geopos_transactions t 
                    JOIN geopos_accounts a ON t.acid = a.id");
echo "Joined Transactions: " . $res->fetch_assoc()['cnt'] . "\n";

// 4. Type match test (Check if 'Income' exists in accounts)
$res = $conn->query("SELECT id, holder, account_type FROM geopos_accounts WHERE account_type = 'Income'");
echo "Income Accounts Found:\n";
while($row = $res->fetch_assoc()) {
    echo "  Account {$row['id']} ({$row['holder']}) type is '{$row['account_type']}'\n";
}

// 5. Combined match test without date/loc
$res = $conn->query("SELECT SUM(t.credit) as total FROM geopos_transactions t 
                    JOIN geopos_accounts a ON t.acid = a.id 
                    WHERE a.account_type = 'Income'");
echo "Income Sum (No filters): " . ($res->fetch_assoc()['total'] ?? 0) . "\n";

// 6. Date filter isolation
$res = $conn->query("SELECT id, date, credit FROM geopos_transactions WHERE credit > 0 AND acid = 19");
echo "ID 19 Credits:\n";
while($row = $res->fetch_assoc()) {
    $d = $row['date'];
    $match = ($d >= $start_date && $d <= $end_date) ? "Matches Range $start_date to $end_date" : "Does NOT Match";
    echo "  ID {$row['id']} | Date: $d | Credit: {$row['credit']} | $match\n";
}

$conn->close();
?>
