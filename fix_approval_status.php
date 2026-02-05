<?php
define('BASEPATH', TRUE);
define('ENVIRONMENT', 'production');
require_once __DIR__ . '/application/config/database.php';

$conn = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h3>Fixing Payroll Status & Schema</h3><pre>";

// 1. Check & Add Columns
$columns = [];
$res = $conn->query("SHOW COLUMNS FROM geopos_payroll_runs");
if ($res) {
    while ($row = $res->fetch_assoc()) $columns[] = $row['Field'];
}

$schema_changes = [
    'approval_status' => "VARCHAR(50) DEFAULT 'Pending'",
    'approved_by' => "INT(11) DEFAULT NULL",
    'approved_date' => "DATETIME DEFAULT NULL"
];

foreach ($schema_changes as $col => $def) {
    if (!in_array($col, $columns)) {
        echo "Adding column '$col'...";
        if ($conn->query("ALTER TABLE geopos_payroll_runs ADD COLUMN $col $def")) echo " OK\n";
        else echo " FAILED: " . $conn->error . "\n";
    } else {
        echo "Column '$col' exists.\n";
    }
}

// 2. Fix inconsistent runs (Transactions exist but Status!=Approved)
echo "\nChecking runs...\n";
$txns = $conn->query("SELECT DISTINCT payer FROM geopos_transactions WHERE payer LIKE 'Payroll Run #%'");
if ($txns) {
    $fixed = 0;
    while ($row = $txns->fetch_assoc()) {
        if (preg_match('/Payroll Run #(\d+)/', $row['payer'], $matches)) {
            $run_id = $matches[1];
            
            // Check current status
            $run_res = $conn->query("SELECT status FROM geopos_payroll_runs WHERE id = $run_id");
            if ($run_res && $run = $run_res->fetch_assoc()) {
                // If transactions exist but status is not Approved, fix it
                if ($run['status'] != 'Approved') {
                    echo "Run #$run_id has journal entries but Status='{$run['status']}'. Fixing...\n";
                    $upd = "UPDATE geopos_payroll_runs SET status='Approved', approval_status='Approved', approved_date=NOW() WHERE id=$run_id";
                    if ($conn->query($upd)) {
                        echo "Run #$run_id updated to Approved ✅\n";
                        $fixed++;
                    } else {
                        echo "Failed to update #$run_id: " . $conn->error . "\n";
                    }
                }
            }
        }
    }
    if ($fixed == 0) echo "All runs with journal entries are already Approved.\n";
}

echo "\nDone! Please refresh your payroll page.</pre>";
$conn->close();
?>
