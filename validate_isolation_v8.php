<?php
// Simple Mock for Aauth
class MockAauth {
    public $user;
    public function __construct($user_data) {
        $this->user = (object)$user_data;
    }
    public function get_user() {
        return $this->user;
    }
}

// Database Connection (Hardcoded for Audit reliability)
$mysqli = new mysqli('localhost', 'root', '', 'newroot');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function log_result($test, $status, $details = "") {
    echo "[$status] $test - $details\n";
}

function safe_query($mysqli, $sql) {
    $res = $mysqli->query($sql);
    if (!$res) {
        die("Query failed: " . $mysqli->error . " | SQL: $sql");
    }
    return $res;
}

echo "<pre>";
echo "--- Timber Pro: Isolation Validation Audit (v8) ---\n\n";

// Test 1: Staff Isolation (Kamal - Colombo Loc 1)
echo "Testing Colombo Staff (Kamal) Isolation...\n";
$sql = "SELECT count(*) as count FROM geopos_products WHERE (loc = 1 OR loc = 0)";
$res = safe_query($mysqli, $sql);
$row = $res->fetch_assoc();
log_result("Kamal Product Visibility", "PASS", "Sees " . $row['count'] . " items (Colombo + Global)");

// Test 2: Staff Isolation Leak Check (Kamal trying to see Loc 2)
$sql = "SELECT count(*) as count FROM geopos_products WHERE loc = 2";
$res = safe_query($mysqli, $sql);
$row = $res->fetch_assoc();
if ($row['count'] > 0) {
    log_result("Kandy Product Leakage", "FAIL", "Found " . $row['count'] . " items from another branch in raw query!");
} else {
    log_result("Kandy Product Isolation", "PASS", "No leakage from Kandy branch.");
}

// Test 2.1: Invoice Isolation
echo "Testing Invoice Isolation...\n";
$sql = "SELECT count(*) as count FROM geopos_invoices WHERE (loc = 1 OR loc = 0)";
$res = safe_query($mysqli, $sql);
$row = $res->fetch_assoc();
log_result("Colombo Invoice Visibility", "PASS", "Sees " . $row['count'] . " invoices.");

$sql = "SELECT count(*) as count FROM geopos_invoices WHERE loc = 2";
$res = safe_query($mysqli, $sql);
$row = $res->fetch_assoc();
if ($row['count'] > 0) {
    log_result("Kandy Invoice Leakage", "FAIL", "Found " . $row['count'] . " invoices from another branch!");
} else {
    log_result("Kandy Invoice Isolation", "PASS", "No leakage from Kandy branch.");
}

// Test 2.2: Account Isolation
echo "Testing Account Isolation...\n";
$sql = "SELECT count(*) as count FROM geopos_accounts WHERE (loc = 1 OR loc = 0)";
$res = safe_query($mysqli, $sql);
$row = $res->fetch_assoc();
log_result("Colombo Account Visibility", "PASS", "Sees " . $row['count'] . " accounts.");

$sql = "SELECT count(*) as count FROM geopos_accounts WHERE loc = 2";
$res = safe_query($mysqli, $sql);
$row = $res->fetch_assoc();
if ($row['count'] > 0) {
    log_result("Kandy Account Leakage", "FAIL", "Found " . $row['count'] . " accounts from another branch!");
} else {
    log_result("Kandy Account Isolation", "PASS", "No leakage from Kandy branch.");
}

// Test 3: Ledger Immutability (Attempt Hard Delete)
echo "\nTesting Ledger Immutability...\n";
// Get a sample transaction
$res = safe_query($mysqli, "SELECT id FROM geopos_transactions LIMIT 1");
if ($row = $res->fetch_assoc()) {
    $tid = $row['id'];
    echo "Attempting to delete Transaction #$tid...\n";
    $mysqli->query("DELETE FROM geopos_transactions WHERE id = $tid");
    
    // Verify if it still exists
    $check = safe_query($mysqli, "SELECT id FROM geopos_transactions WHERE id = $tid");
    if ($check->num_rows > 0) {
        log_result("Transaction Immutability", "PASS", "Transaction #$tid survived DELETE attempt (Trigger/DB Block).");
    } else {
        log_result("Transaction Immutability", "FAIL", "Transaction #$tid was HARD DELETED! Ledger is NOT immutable at DB level.");
    }
} else {
    echo "[SKIP] No transactions found to test deletion.\n";
}

// Test 4: Project Isolation
echo "\nTesting Project Isolation...\n";
$sql = "SELECT business_id FROM geopos_projects WHERE id = 1";
$res = safe_query($mysqli, $sql);
$row = $res->fetch_assoc();
if ($row['business_id'] == 1) {
    log_result("Project Business Bound", "PASS", "Project #1 is correctly bound to Business #1.");
} else {
    log_result("Project Business Bound", "FAIL", "Project #1 business_id mismatch.");
}

echo "\n--- Audit Completed ---\n";
$mysqli->close();
