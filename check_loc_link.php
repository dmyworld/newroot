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

echo "Users by Location (loc):\n";
$res = $conn->query("SELECT id, username, loc FROM geopos_users");
while($row = $res->fetch_assoc()) {
    echo "ID: " . $row['id'] . " | Name: " . $row['username'] . " | Loc: " . $row['loc'] . "\n";
}

echo "\nInvoices by Location (loc):\n";
$res = $conn->query("SELECT loc, COUNT(*) as cnt FROM geopos_invoices GROUP BY loc");
while($row = $res->fetch_assoc()) {
    echo "Loc: " . $row['loc'] . " | Count: " . $row['cnt'] . "\n";
}

$conn->close();
?>
