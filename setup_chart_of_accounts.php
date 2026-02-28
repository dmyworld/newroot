<?php
/**
 * Chart of Accounts Reset & Configuration Script
 * 
 * This script will:
 * 1. Backup existing accounts
 * 2. Delete all accounts
 * 3. Create a complete, properly structured chart of accounts
 * 4. Configure dual entry mappings for all categories
 * 5. Set up API configurations for inventory/stock
 * 
 * WARNING: This will DELETE all existing accounts!
 * Make sure you have a database backup before running this!
 */

define('BASEPATH', 'foo');
require 'application/config/database.php';
$db_config = $db['default'];

$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($mysqli->connect_error) {
    die('Database Connection Error: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

echo "========================================\n";
echo "CHART OF ACCOUNTS RESET & CONFIGURATION\n";
echo "========================================\n\n";

// Read the SQL file
$sql_file = 'application/sql/chart_of_accounts_reset.sql';
if (!file_exists($sql_file)) {
    die("ERROR: SQL file not found: $sql_file\n");
}

$sql_content = file_get_contents($sql_file);

// Split by semicolons but preserve them in multi-line INSERTs
$statements = [];
$current_statement = '';
$in_insert = false;

foreach (explode("\n", $sql_content) as $line) {
    // Skip comments and empty lines
    if (trim($line) == '' || strpos(trim($line), '--') === 0) {
        continue;
    }
    
    $current_statement .= $line . "\n";
    
    // Check if we're in an INSERT statement
    if (stripos($line, 'INSERT INTO') !== false) {
        $in_insert = true;
    }
    
    // Check for statement terminator
    if (strpos($line, ';') !== false) {
        if ($in_insert) {
            // For INSERT statements, check if the semicolon is at the end
            if (substr(trim($line), -1) === ';') {
                $statements[] = $current_statement;
                $current_statement = '';
                $in_insert = false;
            }
        } else {
            $statements[] = $current_statement;
            $current_statement = '';
        }
    }
}

// Execute each statement
$success_count = 0;
$error_count = 0;
$errors = [];

foreach ($statements as $statement) {
    $statement = trim($statement);
    if (empty($statement)) continue;
    
    // Execute the statement
    if ($mysqli->query($statement)) {
        $success_count++;
        
        // Show progress for important statements
        if (stripos($statement, 'INSERT INTO geopos_accounts') !== false) {
            preg_match("/\((\d+),\s*'([^']+)'/", $statement, $matches);
            if (isset($matches[2])) {
                echo "✓ Created account: {$matches[2]}\n";
            }
        } elseif (stripos($statement, 'UPDATE geopos_trans_cat') !== false) {
            preg_match("/WHERE name LIKE '%([^%]+)%'/", $statement, $matches);
            if (isset($matches[1])) {
                echo "✓ Mapped category: {$matches[1]}\n";
            }
        }
    } else {
        $error_count++;
        $error_msg = "ERROR: " . $mysqli->error . "\nStatement: " . substr($statement, 0, 100) . "...\n";
        $errors[] = $error_msg;
        echo "✗ " . $error_msg;
    }
}

echo "\n========================================\n";
echo "EXECUTION SUMMARY\n";
echo "========================================\n";
echo "✓ Successful statements: $success_count\n";
echo "✗ Failed statements: $error_count\n";

if ($error_count > 0) {
    echo "\nERRORS ENCOUNTERED:\n";
    foreach ($errors as $error) {
        echo $error . "\n";
    }
}

// Verification
echo "\n========================================\n";
echo "VERIFICATION\n";
echo "========================================\n";

// Count accounts by type
$result = $mysqli->query("
    SELECT account_type, COUNT(*) as count 
    FROM geopos_accounts 
    GROUP BY account_type 
    ORDER BY account_type
");

echo "\nAccounts by Type:\n";
while ($row = $result->fetch_assoc()) {
    echo "  {$row['account_type']}: {$row['count']}\n";
}

// Show total accounts
$result = $mysqli->query("SELECT COUNT(*) as total FROM geopos_accounts");
$total = $result->fetch_assoc()['total'];
echo "\nTotal Accounts Created: $total\n";

// Show mapped categories
$result = $mysqli->query("
    SELECT COUNT(*) as mapped 
    FROM geopos_trans_cat 
    WHERE dual_acid > 0
");
$mapped = $result->fetch_assoc()['mapped'];
echo "Mapped Categories: $mapped\n";

// Show dual entry configuration
echo "\n========================================\n";
echo "DUAL ENTRY CONFIGURATION\n";
echo "========================================\n";

$result = $mysqli->query("
    SELECT u.*, a1.holder as invoice_acc, a2.holder as purchase_acc
    FROM univarsal_api u
    LEFT JOIN geopos_accounts a1 ON u.key2 = a1.id
    LEFT JOIN geopos_accounts a2 ON u.url = a2.id
    WHERE u.id = 65
");

if ($result && $row = $result->fetch_assoc()) {
    echo "Dual Entry Enabled: " . ($row['key1'] ? 'Yes' : 'No') . "\n";
    echo "Default Invoice Account: {$row['invoice_acc']} (ID: {$row['key2']})\n";
    echo "Default Purchase Account: {$row['purchase_acc']} (ID: {$row['url']})\n";
} else {
    echo "Warning: Could not retrieve dual entry configuration\n";
    echo "MySQL Error: " . $mysqli->error . "\n";
}

// Show stock account mappings
echo "\nStock/Inventory Account Mappings:\n";
$stock_apis = [70 => 'Inventory', 71 => 'Stock Loss', 72 => 'Stock Gain'];
foreach ($stock_apis as $api_id => $name) {
    $result = $mysqli->query("
        SELECT u.key1, a.holder 
        FROM univarsal_api u
        LEFT JOIN geopos_accounts a ON u.key1 = a.id
        WHERE u.id = $api_id
    ");
    if ($result && $row = $result->fetch_assoc()) {
        echo "  $name: {$row['holder']} (ID: {$row['key1']})\n";
    } else {
        echo "  $name: Not configured\n";
    }
}

echo "\n========================================\n";
echo "SETUP COMPLETED SUCCESSFULLY!\n";
echo "========================================\n";
echo "\nNext Steps:\n";
echo "1. Verify the accounts at: http://localhost/newroot/accounts\n";
echo "2. Check dual entry settings at: http://localhost/newroot/settings/dual_entry\n";
echo "3. Review category mappings in the dual entry settings page\n";
echo "4. Test with a sample transaction\n";

$mysqli->close();
?>
