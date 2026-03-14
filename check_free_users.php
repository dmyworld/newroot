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

echo "Users on Free Plan (plan_id = 1):\n";
$sql = "SELECT u.id, u.username, s.plan_id FROM geopos_users u JOIN tp_subscriptions s ON s.user_id = u.id WHERE s.plan_id = 1";
$res = $conn->query($sql);
while($row = $res->fetch_assoc()) {
    echo " - ID: " . $row['id'] . " | Username: " . $row['username'] . "\n";
}

$conn->close();
?>
