<?php
/**
 * Payroll Accounting Integration - Database Auto-Fixer
 * Run this once to add required accounting integration fields
 */

define('BASEPATH', TRUE);
define('ENVIRONMENT', 'development');

require_once __DIR__ . '/application/config/database.php';

$conn = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Payroll Accounting Integration - Database Setup</h2>\n<pre>\n";

// Check and add columns to geopos_payroll_runs
$table = 'geopos_payroll_runs';
$columns_to_add = array(
    'accounting_posted' => "ALTER TABLE `$table` ADD COLUMN `accounting_posted` tinyint(1) DEFAULT 0",
    'accounting_posted_date' => "ALTER TABLE `$table` ADD COLUMN `accounting_posted_date` datetime DEFAULT NULL",
    'payment_posted' => "ALTER TABLE `$table` ADD COLUMN `payment_posted` tinyint(1) DEFAULT 0",
    'payment_posted_date' => "ALTER TABLE `$table` ADD COLUMN `payment_posted_date` datetime DEFAULT NULL"
);

foreach ($columns_to_add as $column => $sql) {
    $result = $conn->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    if ($result->num_rows == 0) {
        echo "Adding column '$column' to $table... ";
        if ($conn->query($sql)) {
            echo "✓ SUCCESS\n";
        } else {
            echo "✗ FAILED: " . $conn->error . "\n";
        }
    } else {
        echo "Column '$column' already exists in $table ✓\n";
    }
}

// Insert default config values
$configs = array(
    'payroll_salary_expense_account' => '0',
    'payroll_epf_payable_account' => '0',
    'payroll_etf_payable_account' => '0',
    'payroll_salary_payable_account' => '0',
    'payroll_payment_account' => '0'
);

echo "\nConfiguring default account mappings...\n";
foreach ($configs as $key => $value) {
    // Check if exists
    $result = $conn->query("SELECT * FROM `geopos_payroll_config` WHERE `name` = '$key'");
    if ($result && $result->num_rows == 0) {
        $sql = "INSERT INTO `geopos_payroll_config` (`name`, `value`, `updated_at`) VALUES ('$key', '$value', NOW())";
        if ($conn->query($sql)) {
            echo "Created config: $key ✓\n";
        } else {
            echo "Failed to create config: $key ✗ " . $conn->error . "\n";
        }
    } else {
        echo "Config already exists: $key ✓\n";
    }
}

echo "\n<strong>✅ SETUP COMPLETE!</strong>\n\n";
echo "Next steps:\n";
echo "1. Go to Payroll Settings to configure account mappings\n";
echo "2. Test by approving a payroll run\n";
echo "3. Check Accounts → Transactions to see journal entries\n";
echo "</pre>";

$conn->close();
?>
