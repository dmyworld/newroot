<?php
header('Content-Type: text/plain');
// Simulating the controller's logic
// We can't easily load CI environment, but we can simulate the DB calls

$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);

$dash_loc = -1; // "All"
$start_date = '2026-02-01';
$end_date = '2026-02-12'; // Using Feb 12 since our transactions have it

echo "--- Simulating Dashboard Metrics (No Date Range for Assets) ---\n";

// get_total_cash_in_hand simulation
$sql = "SELECT SUM(lastbal) as lastbal FROM geopos_accounts 
        WHERE account_type = 'Assets' 
        AND (holder LIKE '%Cash%' OR holder LIKE '%Petty Cash%')";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
$cash = -1 * ($row['lastbal'] ?? 0);
echo "Cash in Hand: $cash\n";

// get_total_bank_balance simulation
$sql = "SELECT SUM(lastbal) as lastbal FROM geopos_accounts 
        WHERE account_type = 'Assets' 
        AND holder LIKE '%Bank%'";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
$bank = -1 * ($row['lastbal'] ?? 0);
echo "Bank Balance: $bank\n";

echo "\n--- Simulating Date-Filtered Metrics (Start: $start_date, End: $end_date) ---\n";

// get_dual_entry_profit simulation
$sql = "SELECT SUM(t.credit) as credit, SUM(t.debit) as debit 
        FROM geopos_transactions t 
        JOIN geopos_accounts a ON t.acid = a.id 
        WHERE (a.account_type = 'Income' OR a.account_type = 'Expenses')
        AND DATE(t.date) >= '$start_date' AND DATE(t.date) <= '$end_date'";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
$profit = ($row['credit'] ?? 0) - ($row['debit'] ?? 0);
echo "Total Profit: $profit\n";

// get_detailed_financial_metrics (Income Sum) simulation
$sql = "SELECT SUM(t.credit) as total FROM geopos_transactions t 
        JOIN geopos_accounts a ON t.acid = a.id 
        WHERE a.account_type = 'Income' AND t.credit > 0
        AND DATE(t.date) >= '$start_date' AND DATE(t.date) <= '$end_date'";
$res = $conn->query($sql);
$row = $res->fetch_assoc();
echo "Agg Revenue: " . ($row['total'] ?? 0) . "\n";

$conn->close();
?>
