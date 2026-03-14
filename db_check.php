<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'c:/Users/user/Documents/GitHub/www/newroot/system/');
define('APPPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/');

require_once(APPPATH . 'config/database.php');
$db_config = $db['default'];

$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    file_put_contents('db_log.txt', "Connection failed: " . $conn->connect_error);
    die();
}

$output = "";
function dump_table($conn, $table, &$output) {
    $output .= "Table: $table\n";
    $res = $conn->query("DESCRIBE $table");
    if (!$res) {
        $output .= "Error describing $table: " . $conn->error . "\n";
        return;
    }
    while($row = $res->fetch_assoc()) {
        $output .= " - {$row['Field']} ({$row['Type']})\n";
    }
    $output .= "\n";
}

dump_table($conn, 'geopos_users', $output);
dump_table($conn, 'tp_subscriptions', $output);
dump_table($conn, 'tp_commission_logs', $output);

file_put_contents('db_log.txt', $output);
echo "Done";
$conn->close();
?>
