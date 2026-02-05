<?php
/**
 * Smart Auto-Fix for Missing Database Elements
 * Checks column existence before adding (MySQL compatible)
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
.step { padding: 15px; margin: 10px 0; border-radius: 5px; background: white; border-left: 5px solid #007bff; }
.success { border-left-color: #28a745; background: #d4edda; }
.skip { border-left-color: #ffc107; background: #fff3cd; }
.error { border-left-color: #dc3545; background: #f8d7da; }
h1 { color: #333; }
</style>";

echo "<h1>🔧 Payroll System Smart Auto-Fix</h1>";

// Helper function to check if column exists
function column_exists($mysqli, $table, $column) {
    $result = $mysqli->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $result && $result->num_rows > 0;
}

$success_count = 0;
$skip_count = 0;
$error_count = 0;

// Fix 1: Create workflow table
echo "<div class='step'><strong>1. Creating geopos_payroll_workflow table...</strong></div>";
$query = "CREATE TABLE IF NOT EXISTS `geopos_payroll_workflow` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `run_id` int(11) NOT NULL,
    `approver_id` int(11) NOT NULL,
    `action` enum('Submitted','Approved','Rejected') DEFAULT 'Submitted',
    `comments` text,
    `action_date` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `run_id` (`run_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

if ($mysqli->query($query)) {
    if ($mysqli->affected_rows > 0) {
        echo "<div class='step success'>✓ Workflow table created</div>";
    } else {
        echo "<div class='step skip'>⊙ Workflow table already exists</div>";
        $skip_count++;
    }
    $success_count++;
} else {
    echo "<div class='step error'>✗ Failed: " . $mysqli->error . "</div>";
    $error_count++;
}

// Fix 2: Add overtime_eligible to employees
echo "<div class='step'><strong>2. Adding overtime_eligible to geopos_employees...</strong></div>";
if (!column_exists($mysqli, 'geopos_employees', 'overtime_eligible')) {
    if ($mysqli->query("ALTER TABLE `geopos_employees` ADD COLUMN `overtime_eligible` tinyint(1) DEFAULT '1'")) {
        echo "<div class='step success'>✓ Column added successfully</div>";
        $success_count++;
    } else {
        echo "<div class='step error'>✗ Failed: " . $mysqli->error . "</div>";
        $error_count++;
    }
} else {
    echo "<div class='step skip'>⊙ Column already exists</div>";
    $success_count++;
    $skip_count++;
}

// Fix 3: Add approved_by to timesheets
echo "<div class='step'><strong>3. Adding approved_by to geopos_timesheets...</strong></div>";
if (!column_exists($mysqli, 'geopos_timesheets', 'approved_by')) {
    if ($mysqli->query("ALTER TABLE `geopos_timesheets` ADD COLUMN `approved_by` int(11) DEFAULT NULL")) {
        echo "<div class='step success'>✓ Column added successfully</div>";
        $success_count++;
    } else {
        echo "<div class='step error'>✗ Failed: " . $mysqli->error . "</div>";
        $error_count++;
    }
} else {
    echo "<div class='step skip'>⊙ Column already exists</div>";
    $success_count++;
    $skip_count++;
}

// Fix 4: Add approved_date to timesheets
echo "<div class='step'><strong>4. Adding approved_date to geopos_timesheets...</strong></div>";
if (!column_exists($mysqli, 'geopos_timesheets', 'approved_date')) {
    if ($mysqli->query("ALTER TABLE `geopos_timesheets` ADD COLUMN `approved_date` datetime DEFAULT NULL")) {
        echo "<div class='step success'>✓ Column added successfully</div>";
        $success_count++;
    } else {
        echo "<div class='step error'>✗ Failed: " . $mysqli->error . "</div>";
        $error_count++;
    }
} else {
    echo "<div class='step skip'>⊙ Column already exists</div>";
    $success_count++;
    $skip_count++;
}

// Fix 5: Add cola_amount to payroll_items
echo "<div class='step'><strong>5. Adding cola_amount to geopos_payroll_items...</strong></div>";
if (!column_exists($mysqli, 'geopos_payroll_items', 'cola_amount')) {
    if ($mysqli->query("ALTER TABLE `geopos_payroll_items` ADD COLUMN `cola_amount` decimal(10,2) DEFAULT '0.00'")) {
        echo "<div class='step success'>✓ Column added successfully</div>";
        $success_count++;
    } else {
        echo "<div class='step error'>✗ Failed: " . $mysqli->error . "</div>";
        $error_count++;
    }
} else {
    echo "<div class='step skip'>⊙ Column already exists</div>";
    $success_count++;
    $skip_count++;
}

// Fix 6: Add overtime_pay to payroll_items
echo "<div class='step'><strong>6. Adding overtime_pay to geopos_payroll_items...</strong></div>";
if (!column_exists($mysqli, 'geopos_payroll_items', 'overtime_pay')) {
    if ($mysqli->query("ALTER TABLE `geopos_payroll_items` ADD COLUMN `overtime_pay` decimal(10,2) DEFAULT '0.00'")) {
        echo "<div class='step success'>✓ Column added successfully</div>";
        $success_count++;
    } else {
        echo "<div class='step error'>✗ Failed: " . $mysqli->error . "</div>";
        $error_count++;
    }
} else {
    echo "<div class='step skip'>⊙ Column already exists</div>";
    $success_count++;
    $skip_count++;
}

// Summary
echo "<div style='background: white; padding: 20px; margin-top: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>";
echo "<h2>📊 Summary</h2>";
echo "<p style='font-size: 18px;'><strong>Total Fixes:</strong> 6</p>";
echo "<p style='font-size: 18px;'><strong>Successful:</strong> <span style='color: #28a745;'>$success_count</span></p>";
echo "<p style='font-size: 18px;'><strong>Already Existed:</strong> <span style='color: #ffc107;'>$skip_count</span></p>";
if ($error_count > 0) {
    echo "<p style='font-size: 18px;'><strong>Errors:</strong> <span style='color: #dc3545;'>$error_count</span></p>";
}

if ($error_count == 0) {
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 5px; margin-top: 15px;'>";
    echo "<h3 style='margin: 0 0 10px 0;'>🎉 All fixes applied successfully!</h3>";
    echo "<p style='margin: 0;'>Your payroll system is now complete.</p>";
    echo "<p style='margin: 10px 0 0 0;'><strong>Next step:</strong> <a href='test_payroll_system.php' style='color: #007bff; font-weight: bold; text-decoration: none;'>→ Re-run Test Suite</a> to verify 100% pass rate.</p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin-top: 15px;'>";
    echo "<strong>⚠ Some fixes failed.</strong><br>";
    echo "Please check the errors above. You may need to manually add these columns.";
    echo "</div>";
}
echo "</div>";

$mysqli->close();
?>
