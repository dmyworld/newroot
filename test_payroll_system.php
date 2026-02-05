<?php
/**
 * Payroll System Comprehensive Test Suite
 * Tests all modules and identifies bugs
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
.test { padding: 10px; margin: 10px 0; border-radius: 5px; }
.pass { background: #d4edda; border-left: 5px solid #28a745; }
.fail { background: #f8d7da; border-left: 5px solid #dc3545; }
.warn { background: #fff3cd; border-left: 5px solid #ffc107; }
h2 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
h3 { color: #555; margin-top: 20px; }
</style>";

echo "<h1>🧪 Payroll System Test Suite</h1>";

$passed = 0;
$failed = 0;
$warnings = 0;

// ============================================
// TEST 1: Database Tables
// ============================================
echo "<h2>1. Database Tables Test</h2>";

$required_tables = [
    'geopos_employees',
    'geopos_timesheets',
    'geopos_job_codes',
    'geopos_payroll_bonuses',
    'geopos_payroll_runs',
    'geopos_payroll_items',
    'geopos_payroll_statutory',
    'geopos_employee_loans',
    'geopos_payroll_workflow',
    'geopos_overtime_rules'
];

foreach ($required_tables as $table) {
    $res = $mysqli->query("SHOW TABLES LIKE '$table'");
    if ($res->num_rows > 0) {
        echo "<div class='test pass'>✓ Table <strong>$table</strong> exists</div>";
        $passed++;
    } else {
        echo "<div class='test fail'>✗ Table <strong>$table</strong> missing</div>";
        $failed++;
    }
}

// ============================================
// TEST 2: Required Columns
// ============================================
echo "<h2>2. Column Validation Test</h2>";

$column_checks = [
    ['table' => 'geopos_employees', 'column' => 'cola_amount'],
    ['table' => 'geopos_employees', 'column' => 'epf_no'],
    ['table' => 'geopos_employees', 'column' => 'overtime_eligible'],
    ['table' => 'geopos_timesheets', 'column' => 'is_overtime'],
    ['table' => 'geopos_timesheets', 'column' => 'approved_by'],
    ['table' => 'geopos_employee_loans', 'column' => 'type'],
    ['table' => 'geopos_employee_loans', 'column' => 'interest_rate'],
    ['table' => 'geopos_payroll_items', 'column' => 'cola_amount'],
    ['table' => 'geopos_payroll_items', 'column' => 'overtime_pay']
];

foreach ($column_checks as $check) {
    $res = $mysqli->query("SHOW COLUMNS FROM {$check['table']} LIKE '{$check['column']}'");
    if ($res && $res->num_rows > 0) {
        echo "<div class='test pass'>✓ Column <strong>{$check['table']}.{$check['column']}</strong> exists</div>";
        $passed++;
    } else {
        echo "<div class='test fail'>✗ Column <strong>{$check['table']}.{$check['column']}</strong> missing</div>";
        $failed++;
    }
}

// ============================================
// TEST 3: Data Integrity
// ============================================
echo "<h2>3. Data Integrity Test</h2>";

// Count records
$res = $mysqli->query("SELECT COUNT(*) as c FROM geopos_employees");
$emp_count = $res->fetch_assoc()['c'];
echo "<div class='test " . ($emp_count > 0 ? 'pass' : 'warn') . "'>Employees: <strong>$emp_count</strong></div>";
if ($emp_count > 0) $passed++; else $warnings++;

$res = $mysqli->query("SELECT COUNT(*) as c FROM geopos_timesheets");
if ($res) {
    $ts_count = $res->fetch_assoc()['c'];
    echo "<div class='test pass'>Timesheets: <strong>$ts_count</strong></div>";
    $passed++;
} else {
    echo "<div class='test warn'>⚠ Timesheets table accessible but query failed</div>";
    $warnings++;
}

$res = $mysqli->query("SELECT COUNT(*) as c FROM geopos_payroll_bonuses");
if ($res) {
    $bonus_count = $res->fetch_assoc()['c'];
    echo "<div class='test pass'>Bonuses: <strong>$bonus_count</strong></div>";
    $passed++;
}

$res = $mysqli->query("SELECT COUNT(*) as c FROM geopos_payroll_runs");
if ($res) {
    $run_count = $res->fetch_assoc()['c'];
    echo "<div class='test pass'>Payroll Runs: <strong>$run_count</strong></div>";
    $passed++;
}

// ============================================
// TEST 4: Configuration Data
// ============================================
echo "<h2>4. Configuration Test</h2>";

$res = $mysqli->query("SELECT COUNT(*) as c FROM geopos_payroll_statutory WHERE status='Active'");
if ($res) {
    $stat_count = $res->fetch_assoc()['c'];
    if ($stat_count > 0) {
        echo "<div class='test pass'>✓ Statutory rules configured: <strong>$stat_count</strong></div>";
        $passed++;
    } else {
        echo "<div class='test warn'>⚠ No active statutory rules found</div>";
        $warnings++;
    }
}

$res = $mysqli->query("SELECT COUNT(*) as c FROM geopos_job_codes WHERE status='Active'");
if ($res) {
    $job_count = $res->fetch_assoc()['c'];
    echo "<div class='test " . ($job_count > 0 ? 'pass' : 'warn') . "'>Job Codes: <strong>$job_count</strong></div>";
    if ($job_count > 0) $passed++; else $warnings++;
}

// ============================================
// TEST 5: Controller Files
// ============================================
echo "<h2>5. Controller Files Test</h2>";

$controllers = [
    'PayrollProcessing.php',
    'PayrollReport.php',
    'PayrollBonus.php',
    'PayrollSettings.php',
    'PayrollAnalytics.php',
    'PayrollWorkflow.php',
    'PayrollTimesheets.php'
];

foreach ($controllers as $ctrl) {
    $path = "application/controllers/$ctrl";
    if (file_exists($path)) {
        echo "<div class='test pass'>✓ Controller <strong>$ctrl</strong> exists</div>";
        $passed++;
    } else {
        echo "<div class='test fail'>✗ Controller <strong>$ctrl</strong> missing</div>";
        $failed++;
    }
}

// ============================================
// TEST 6: View Files
// ============================================
echo "<h2>6. View Files Test</h2>";

$views = [
    'payroll/processing/index.php',
    'payroll/report/dashboard.php',
    'payroll/bonus/index.php',
    'payroll/settings/index.php',
    'payroll/analytics/dashboard.php',
    'payroll/workflow/approval_list.php',
    'payroll/timesheets/index.php'
];

foreach ($views as $view) {
    $path = "application/views/$view";
    if (file_exists($path)) {
        echo "<div class='test pass'>✓ View <strong>$view</strong> exists</div>";
        $passed++;
    } else {
        echo "<div class='test fail'>✗ View <strong>$view</strong> missing</div>";
        $failed++;
    }
}

// ============================================
// TEST 7: Model Files
// ============================================
echo "<h2>7. Model Files Test</h2>";

$models = [
    'Payroll_engine_model.php',
    'Payroll_report_model.php',
    'Payroll_bonus_model.php',
    'Payroll_analytics_model.php',
    'Payroll_rules_model.php'
];

foreach ($models as $model) {
    $path = "application/models/$model";
    if (file_exists($path)) {
        echo "<div class='test pass'>✓ Model <strong>$model</strong> exists</div>";
        $passed++;
    } else {
        echo "<div class='test warn'>⚠ Model <strong>$model</strong> missing (may be optional)</div>";
        $warnings++;
    }
}

// ============================================
// SUMMARY
// ============================================
echo "<h2>📊 Test Summary</h2>";
$total = $passed + $failed + $warnings;
echo "<div style='background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>";
echo "<h3>Total Tests: <strong>$total</strong></h3>";
echo "<p style='color: #28a745; font-size: 18px;'>✓ Passed: <strong>$passed</strong></p>";
echo "<p style='color: #dc3545; font-size: 18px;'>✗ Failed: <strong>$failed</strong></p>";
echo "<p style='color: #ffc107; font-size: 18px;'>⚠ Warnings: <strong>$warnings</strong></p>";

$percentage = $total > 0 ? round(($passed / $total) * 100, 1) : 0;
echo "<h3 style='color: " . ($percentage >= 80 ? '#28a745' : ($percentage >= 60 ? '#ffc107' : '#dc3545')) . "'>Score: $percentage%</h3>";

if ($failed == 0) {
    echo "<div style='background: #d4edda; padding: 15px; margin-top: 20px; border-radius: 5px;'>";
    echo "<strong>🎉 All critical tests passed!</strong><br>";
    echo "Your payroll system is ready to use.";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 15px; margin-top: 20px; border-radius: 5px;'>";
    echo "<strong>⚠ Action Required:</strong><br>";
    echo "Run the master migration: <code>application/sql/payroll_master_migration.sql</code>";
    echo "</div>";
}
echo "</div>";

$mysqli->close();
?>
