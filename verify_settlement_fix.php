<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'c:/Users/user/Documents/GitHub/www/newroot/system/');
define('APPPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/');

require_once(APPPATH . 'config/database.php');
$db_config = $db['default'];

$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Connection failed\n");
}

echo "Starting verification of Settle Payment fix...\n";

// 1. Check if 'Platform Revenue' account exists - should be created by model if missing
echo "Checking Platform Revenue account...\n";
$res = $conn->query("SELECT * FROM geopos_accounts WHERE holder = 'Platform Revenue'");
if ($row = $res->fetch_assoc()) {
    echo "SUCCESS: Account found. ID=" . $row['id'] . ", Balance=" . $row['lastbal'] . "\n";
} else {
    echo "INFO: Account not found yet. This is expected if 'settle' hasn't been called via the application.\n";
    echo "Run the settlement in the browser first to trigger auto-creation.\n";
}

// 2. Check for recent transactions
echo "\nChecking recent 'Subscription Commission' transactions...\n";
$res = $conn->query("SELECT * FROM geopos_transactions WHERE cat = 'Subscription Commission' ORDER BY id DESC LIMIT 5");
if ($res->num_rows > 0) {
    while($row = $res->fetch_assoc()) {
        echo "  TID: " . $row['tid'] . " | Amount: " . $row['credit'] . " | Date: " . $row['date'] . " | Payer: " . $row['payer'] . "\n";
    }
} else {
    echo "No transactions found yet.\n";
}

$conn->close();
?>
