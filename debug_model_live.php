<?php
// We can't easily include the whole CI environment here without breaking something
// But we can check if there's any obvious logic error in the model file itself by reading it again.

header('Content-Type: text/plain');
$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);

$branch_id = -1; // "All"
$start_date = '2026-02-01';
$end_date = '2026-02-11';

echo "--- Debugging get_detailed_financial_metrics simulation ---\n";

// Replicating Intelligence_model.php exactly for Income
$income_sql = "SELECT t.method, SUM(t.credit) as total 
               FROM geopos_transactions t 
               LEFT JOIN geopos_accounts a ON t.acid = a.id 
               WHERE t.credit > 0 
               AND a.account_type = 'Income'";
// No loc filter for -1
$income_sql .= " AND DATE(t.date) >= '$start_date' AND DATE(t.date) <= '$end_date'";
$income_sql .= " GROUP BY t.method";

echo "SQL: $income_sql\n";
$res = $conn->query($income_sql);
if ($res->num_rows > 0) {
    while($row = $res->fetch_assoc()) {
        echo "  Method: {$row['method']} | Total: {$row['total']}\n";
    }
} else {
    echo "  No Income Transactions Found inside range.\n";
}

// Check what's outside the range
$res = $conn->query("SELECT id, date, credit FROM geopos_transactions WHERE acid = 19");
echo "\n--- All Credits for Account 19 ---\n";
while($row = $res->fetch_assoc()) {
    echo "  ID: {$row['id']} | Date: {$row['date']} | Credit: {$row['credit']}\n";
}

$conn->close();
?>
