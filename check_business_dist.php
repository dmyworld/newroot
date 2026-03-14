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

echo "Users by Business ID:\n";
$res = $conn->query("SELECT business_id, COUNT(*) as user_count FROM geopos_users GROUP BY business_id");
while($row = $res->fetch_assoc()) {
    echo "Business ID: " . $row['business_id'] . " | Users: " . $row['user_count'] . "\n";
}

$conn->close();
?>
