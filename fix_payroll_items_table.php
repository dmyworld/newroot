<?php
/**
 * Fix Missing Columns in geopos_payroll_items
 */

define('BASEPATH', 'test');
define('ENVIRONMENT', 'development');
include('application/config/database.php');
$config = $db['default'];

$mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);

if ($mysqli->connect_error) {
    die("❌ Connection failed: " . $mysqli->connect_error);
}

echo "<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
.success { padding: 15px; margin: 10px 0; background: #d4edda; border-left: 5px solid #28a745; border-radius: 5px; }
.error { padding: 15px; margin: 10px 0; background: #f8d7da; border-left: 5px solid #dc3545; border-radius: 5px; }
.info { padding: 15px; margin: 10px 0; background: #d1ecf1; border-left: 5px solid #17a2b8; border-radius: 5px; }
h1 { color: #333; }
</style>";

echo "<h1>🔧 Fix Payroll Items Table</h1>";

// Check which columns are missing
$existing_columns = array();
$result = $mysqli->query("SHOW COLUMNS FROM geopos_payroll_items");
while($row = $result->fetch_assoc()) {
    $existing_columns[] = $row['Field'];
}

$required_columns = array(
    'epf_employee' => 'decimal(10,2) DEFAULT 0.00',
    'epf_employer' => 'decimal(10,2) DEFAULT 0.00',
    'etf_employer' => 'decimal(10,2) DEFAULT 0.00',
    'loan_deduction' => 'decimal(10,2) DEFAULT 0.00',
    'other_deductions' => 'decimal(10,2) DEFAULT 0.00',
    'basic_salary' => 'decimal(10,2) DEFAULT 0.00',
    'bonus_amount' => 'decimal(10,2) DEFAULT 0.00'
);

$missing = array();
foreach($required_columns as $col => $def) {
    if(!in_array($col, $existing_columns)) {
        $missing[$col] = $def;
    }
}

if(empty($missing)) {
    echo "<div class='success'><strong>✓ All columns exist!</strong> No fixes needed.</div>";
} else {
    echo "<div class='info'><strong>Missing columns found:</strong> " . implode(', ', array_keys($missing)) . "</div>";
    
    foreach($missing as $col => $def) {
        $sql = "ALTER TABLE geopos_payroll_items ADD COLUMN `$col` $def";
        if($mysqli->query($sql)) {
            echo "<div class='success'>✓ Added column: <strong>$col</strong></div>";
        } else {
            echo "<div class='error'>✗ Failed to add <strong>$col</strong>: " . $mysqli->error . "</div>";
        }
    }
}

echo "<div class='info' style='margin-top: 30px;'>";
echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Table structure is now fixed</li>";
echo "<li>Go to <a href='payrollprocessing'>Payroll Processing</a></li>";
echo "<li>Select employees and generate a new payroll run</li>";
echo "<li>All deduction components will now save properly</li>";
echo "</ol>";
echo "</div>";

$mysqli->close();
?>
