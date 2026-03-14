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

echo "Checking tp_commissions table:\n";
$res = $conn->query("SHOW TABLES LIKE 'tp_commissions'");
if ($res->num_rows > 0) {
    echo "tp_commissions exists.\n";
    $res = $conn->query("SHOW COLUMNS FROM tp_commissions");
    while($row = $res->fetch_assoc()) {
        echo "  Field: " . $row['Field'] . " | Type: " . $row['Type'] . "\n";
    }
} else {
    echo "tp_commissions DOES NOT exist.\n";
}

echo "\nChecking Platform Revenue account:\n";
$res = $conn->query("SELECT * FROM geopos_accounts WHERE holder = 'Platform Revenue'");
if ($row = $res->fetch_assoc()) {
    echo "Account found: ID=" . $row['id'] . ", Holder=" . $row['holder'] . "\n";
} else {
    echo "Account 'Platform Revenue' NOT found.\n";
}

$conn->close();
?>
