<?php
$mysqli = new mysqli("localhost", "root", "", "timberpro");
if ($mysqli->connect_error) {
    die("Connect Error: " . $mysqli->connect_error);
}

echo "=== VERIFYING DATABASE TABLES ===\n\n";

// Check geopos_market_requests
$result = $mysqli->query("SELECT COUNT(*) as cnt FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'timberpro' AND TABLE_NAME = 'geopos_market_requests'");
$row = $result->fetch_assoc();
echo "geopos_market_requests: " . ($row['cnt'] > 0 ? "✓ EXISTS" : "✗ MISSING") . "\n";

// Check geopos_worker_profiles
$result = $mysqli->query("SELECT COUNT(*) as cnt FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'timberpro' AND TABLE_NAME = 'geopos_worker_profiles'");
$row = $result->fetch_assoc();
echo "geopos_worker_profiles: " . ($row['cnt'] > 0 ? "✓ EXISTS" : "✗ MISSING") . "\n";

echo "\n=== VERIFYING MODEL FILES ===\n";
echo "Worker_model.php: " . (file_exists(__DIR__ . '/application/models/Worker_model.php') ? "✓ EXISTS" : "✗ MISSING") . "\n";

echo "\n=== VERIFYING CONTROLLER FILES ===\n";
echo "Worker.php: " . (file_exists(__DIR__ . '/application/controllers/Worker.php') ? "✓ EXISTS" : "✗ MISSING") . "\n";

echo "\n=== VERIFYING VIEW FILES ===\n";
echo "worker/register.php: " . (file_exists(__DIR__ . '/application/views/worker/register.php') ? "✓ EXISTS" : "✗ MISSING") . "\n";
echo "worker/browse.php: " . (file_exists(__DIR__ . '/application/views/worker/browse.php') ? "✓ EXISTS" : "✗ MISSING") . "\n";
echo "marketplace/public_marketplace.php: " . (file_exists(__DIR__ . '/application/views/marketplace/public_marketplace.php') ? "✓ EXISTS" : "✗ MISSING") . "\n";

echo "\n✅ Verification complete!\n";
?>
