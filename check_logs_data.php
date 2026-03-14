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

$res = $conn->query("SELECT * FROM tp_commission_logs");
if ($res->num_rows == 0) {
    echo "No commission logs found.";
} else {
    while($row = $res->fetch_assoc()) {
        echo "ID: " . $row['id'] . " | UserID: " . $row['user_id'] . " | Amount: " . $row['amount'] . "\n";
    }
}

$conn->close();
?>
