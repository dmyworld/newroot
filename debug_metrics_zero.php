<?php
header('Content-Type: text/plain');
$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

echo "--- Account Types Check ---\n";
$res = $conn->query("SELECT id, holder, account_type, lastbal, loc FROM geopos_accounts WHERE id IN (1, 19, 26)");
while($row = $res->fetch_assoc()) {
    echo "ID: {$row['id']} | Holder: {$row['holder']} | Type: {$row['account_type']} | Bal: {$row['lastbal']} | Loc: {$row['loc']}\n";
}

echo "\n--- Transaction Loc/Date Check ---\n";
$res = $conn->query("SELECT id, acid, debit, credit, loc, date FROM geopos_transactions WHERE id > 40");
while($row = $res->fetch_assoc()) {
    echo "ID: {$row['id']} | Acid: {$row['acid']} | D: {$row['debit']} | C: {$row['credit']} | Loc: {$row['loc']} | Date: {$row['date']}\n";
}

echo "\n--- Aggregation Test (Simulating Model) ---\n";
$start_date = date('Y-m-01');
$end_date = date('Y-m-d');
$loc = 0;

$sql = "SELECT SUM(t.credit) as total FROM geopos_transactions t 
        JOIN geopos_accounts a ON t.acid = a.id 
        WHERE t.credit > 0 AND a.account_type = 'Income' 
        AND t.loc = $loc AND DATE(t.date) >= '$start_date' AND DATE(t.date) <= '$end_date'";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
echo "Income Sum (Loc $loc): " . ($row['total'] ?? 0) . "\n";

$sql_no_loc = "SELECT SUM(t.credit) as total FROM geopos_transactions t 
        JOIN geopos_accounts a ON t.acid = a.id 
        WHERE t.credit > 0 AND a.account_type = 'Income' 
        AND DATE(t.date) >= '$start_date' AND DATE(t.date) <= '$end_date'";
$res = $conn->query($sql_no_loc);
$row = $res->fetch_assoc();
echo "Income Sum (No Loc Filter): " . ($row['total'] ?? 0) . "\n";

$conn->close();
?>
