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

echo "Invoice EID Frequency:\n";
$res = $conn->query("SELECT eid, COUNT(*) as cnt FROM geopos_invoices GROUP BY eid");
while($row = $res->fetch_assoc()) {
    echo "EID: " . $row['eid'] . " | Count: " . $row['cnt'] . "\n";
}

$conn->close();
?>
