<?php
/**
 * Test Payroll Accounting Integration
 * This script checks if everything is configured correctly
 */

define('BASEPATH', TRUE);
require_once __DIR__ . '/application/config/database.php';

$conn = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Payroll Accounting Integration - Status Check</h2>\n<pre>\n";

// 1. Check database columns
echo "=== DATABASE STRUCTURE ===\n";
$columns = ['accounting_posted', 'accounting_posted_date', 'payment_posted', 'payment_posted_date'];
$result = $conn->query("SHOW COLUMNS FROM geopos_payroll_runs");
$existing_columns = [];
while ($row = $result->fetch_assoc()) {
    $existing_columns[] = $row['Field'];
}

foreach ($columns as $col) {
    echo (in_array($col, $existing_columns) ? '✓' : '✗') . " Column: $col\n";
}

// 2. Check config values
echo "\n=== ACCOUNT MAPPINGS ===\n";
$configs = [
    'payroll_salary_expense_account' => 'Salary Expense Account',
    'payroll_epf_payable_account' => 'EPF Payable Account',
    'payroll_etf_payable_account' => 'ETF Payable Account',
    'payroll_salary_payable_account' => 'Salary Payable Account',
    'payroll_payment_account' => 'Payment Account'
];

$all_configured = true;
foreach ($configs as $key => $label) {
    $result = $conn->query("SELECT value FROM geopos_payroll_config WHERE name = '$key'");
    if ($result && $row = $result->fetch_assoc()) {
        $value = $row['value'];
        if ($value == '0' || empty($value)) {
            echo "⚠ $label: NOT CONFIGURED (value=$value)\n";
            $all_configured = false;
        } else {
            // Get account name
            $acc_result = $conn->query("SELECT holder, acn FROM geopos_accounts WHERE id = $value");
            if ($acc_result && $acc = $acc_result->fetch_assoc()) {
                echo "✓ $label: {$acc['acn']} - {$acc['holder']}\n";
            } else {
                echo "⚠ $label: Account ID $value not found\n";
                $all_configured = false;
            }
        }
    } else {
        echo "✗ $label: Config missing\n";
        $all_configured = false;
    }
}

// 3. Check for recent payroll runs
echo "\n=== RECENT PAYROLL RUNS ===\n";
$result = $conn->query("SELECT id, start_date, end_date, status, accounting_posted, accounting_posted_date FROM geopos_payroll_runs ORDER BY id DESC LIMIT 5");
if ($result && $result->num_rows > 0) {
    echo sprintf("%-5s %-12s %-12s %-10s %-8s %s\n", "ID", "Start", "End", "Status", "Posted", "Posted Date");
    echo str_repeat("-", 80) . "\n";
    while ($row = $result->fetch_assoc()) {
        echo sprintf("%-5s %-12s %-12s %-10s %-8s %s\n", 
            $row['id'], 
            $row['start_date'], 
            $row['end_date'], 
            $row['status'],
            $row['accounting_posted'] ? 'YES' : 'NO',
            $row['accounting_posted_date'] ?: 'N/A'
        );
    }
} else {
    echo "No payroll runs found\n";
}

// 4. Check for existing transactions
echo "\n=== PAYROLL TRANSACTIONS ===\n";
$result = $conn->query("SELECT COUNT(*) as count FROM geopos_transactions WHERE payer LIKE '%Payroll Run%'");
if ($result && $row = $result->fetch_assoc()) {
    echo "Total payroll transactions: {$row['count']}\n";
    
    if ($row['count'] > 0) {
        $recent = $conn->query("SELECT payer, method, debit, credit, date FROM geopos_transactions WHERE payer LIKE '%Payroll Run%' ORDER BY id DESC LIMIT 5");
        echo "\nRecent entries:\n";
        echo sprintf("%-30s %-12s %-12s %-12s %s\n", "Description", "Method", "Debit", "Credit", "Date");
        echo str_repeat("-", 80) . "\n";
        while ($t = $recent->fetch_assoc()) {
            echo sprintf("%-30s %-12s %-12s %-12s %s\n", 
                substr($t['payer'], 0, 30),
                substr($t['method'], 0, 12),
                number_format($t['debit'], 2),
                number_format($t['credit'], 2),
                $t['date']
            );
        }
    }
}

// 5. Summary
echo "\n=== SUMMARY ===\n";
if ($all_configured) {
    echo "✅ All account mappings are configured\n";
    echo "✅ System is ready to create journal entries\n";
    echo "\nNext: Approve a payroll run and check for new transactions\n";
} else {
    echo "⚠ CONFIGURATION REQUIRED\n";
    echo "\nPlease go to: Payroll → Settings → Accounts Integration\n";
    echo "and configure all account mappings before approving payroll runs.\n";
}

echo "</pre>";
$conn->close();
?>
