<?php
define('BASEPATH', TRUE);
require_once __DIR__ . '/application/config/database.php';

$conn = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h3>Payroll Run Status Debug</h3>\n<pre>\n";

// Check the most recent payroll run
$result = $conn->query("SELECT id, start_date, end_date, status, approval_status, approved_by, approved_date, accounting_posted, accounting_posted_date FROM geopos_payroll_runs ORDER BY id DESC LIMIT 3");

echo sprintf("%-5s %-12s %-12s %-12s %-12s %-12s %-20s %-8s %s\n", "ID", "Start", "End", "Status", "ApprovalSts", "ApprovedBy", "ApprovedDate", "AcctPost", "AcctPostDate");
echo str_repeat("-", 120) . "\n";

while ($row = $result->fetch_assoc()) {
    echo sprintf("%-5s %-12s %-12s %-12s %-12s %-12s %-20s %-8s %s\n", 
        $row['id'],
        $row['start_date'],
        $row['end_date'],
        $row['status'] ?: 'NULL',
        $row['approval_status'] ?: 'NULL',
        $row['approved_by'] ?: 'NULL',
        $row['approved_date'] ?: 'NULL',
        $row['accounting_posted'] ? 'YES' : 'NO',
        $row['accounting_posted_date'] ?: 'N/A'
    );
}

// Check transactions for the latest run
echo "\n\n<h4>Transactions for Latest Run:</h4>\n";
$latest = $conn->query("SELECT id FROM geopos_payroll_runs ORDER BY id DESC LIMIT 1")->fetch_assoc()['id'];
$trans = $conn->query("SELECT payer, method, debit, credit FROM geopos_transactions WHERE payer LIKE '%Payroll Run #$latest%' ORDER BY id DESC");

if ($trans && $trans->num_rows > 0) {
    echo sprintf("%-35s %-12s %-12s %s\n", "Payer", "Method", "Debit", "Credit");
    echo str_repeat("-", 80) . "\n";
    while ($t = $trans->fetch_assoc()) {
        echo sprintf("%-35s %-12s %-12s %s\n",
            $t['payer'],
            $t['method'],
            number_format($t['debit'], 2),
            number_format($t['credit'], 2)
        );
    }
} else {
    echo "No transactions found for run #$latest\n";
}

echo "</pre>";
$conn->close();
?>
