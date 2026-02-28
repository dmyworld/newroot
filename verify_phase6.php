<?php
define('BASEPATH', 'index.php');
define('ENVIRONMENT', 'development');
require_once('index.php');
$CI =& get_instance();
$CI->load->database();
$CI->load->library("Aauth");

// Mock user login if needed (usually not for CLI if DB is accessible)
// But models might use $this->aauth->get_user()

echo "--- Phase 6 Verification ---\n";

// 1. Check Configuration Storage
echo "Checking univarsal_api ID 70...\n";
$CI->db->where('id', 70);
$config = $CI->db->get('univarsal_api')->row_array();
if ($config) {
    echo "Config Found: Sales: {$config['key1']}, Inventory: {$config['key2']}, Purchase: {$config['url']}\n";
} else {
    echo "Config NOT Found (Expected if not saved via UI yet)\n";
    // Seed it for testing
    $CI->db->insert('univarsal_api', ['id' => 70, 'key1' => 1, 'key2' => 2, 'url' => 3, 'name' => 'timber_finance']);
    echo "Seeded temporary config.\n";
}

// 2. Test TimberPro Acquisition Transaction
echo "\nTesting TimberPro Acquisition recording...\n";
$CI->load->model('TimberPro_model', 'timberpro');
$lot_name = "Test Lot " . time();
$logs = [
    ['length' => 10, 'girth' => 40, 'cubic_feet' => 1.38],
    ['length' => 12, 'girth' => 42, 'cubic_feet' => 1.71]
];
$result = $CI->timberpro->save_logs($lot_name, 1, $logs, "0,0");
echo "Save Logs Result: " . $result['status'] . "\n";

if ($result['status'] == 'Success') {
    $lot_id = $result['lot_id'];
    $CI->db->where('tid', $lot_id);
    $CI->db->where('ext', 2);
    $trans = $CI->db->get('geopos_transactions')->row_array();
    if ($trans) {
        echo "Acquisition Transaction Recorded Successfully! TID: {$trans['id']}, Note: {$trans['note']}\n";
    } else {
        echo "FAILED: Acquisition Transaction NOT Recorded.\n";
    }
}

// 3. Test Marketplace Sale Double-Entry
echo "\nTesting Marketplace Sale double-entry...\n";
$CI->load->model('Marketplace_model', 'marketplace');
// Create a dummy bid
$bid_data = [
    'lot_id' => 1,
    'lot_type' => 'logs',
    'bid_amount' => 5000,
    'buyer_id' => 1,
    'status' => 'approved'
];
$CI->db->insert('geopos_timber_bids', $bid_data);
$bid_id = $CI->db->insert_id();

echo "Marking Bid #$bid_id as sold...\n";
$CI->marketplace->update_bid_status($bid_id, 'sold');

// Check for double entry
$CI->db->where('tid', $bid_id);
$CI->db->where('method', 'Marketplace');
$trans_count = $CI->db->count_all_results('geopos_transactions');
if ($trans_count >= 2) {
    echo "Double-Entry Transactions Recorded Successfully! Count: $trans_count\n";
} else {
    echo "FAILED: Double-Entry Transactions NOT Recorded (Count: $trans_count).\n";
}

echo "\n--- Verification Complete ---\n";
