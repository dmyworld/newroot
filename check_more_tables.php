<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'c:/Users/user/Documents/GitHub/www/newroot/system/');
define('APPPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/');

require_once(APPPATH . 'config/database.php');
$db_config = $db['default'];

$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Connection failed");
}

function check_table($conn, $table) {
    echo "Table: $table\n";
    $res = $conn->query("SHOW TABLES LIKE '$table'");
    if ($res->num_rows == 0) {
        echo " - Table does not exist\n";
        return;
    }
    $res = $conn->query("DESCRIBE $table");
    while($row = $res->fetch_assoc()) {
        echo " - " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
}

check_table($conn, 'tp_commissions');
echo "\n";
check_table($conn, 'geopos_accounts');
echo "\n";
check_table($conn, 'geopos_transactions');

$conn->close();
?>
