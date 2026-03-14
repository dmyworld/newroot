<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'dummy');
include 'application/config/database.php';
$db_config = $db['default'];
$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

$res = $conn->query("SELECT id, username, pass FROM geopos_users WHERE username = 'timberpro_owner'");
if ($row = $res->fetch_assoc()) {
    $uid = $row['id'];
    $db_pass = $row['pass'];
    $raw = '123456*';
    
    // Simulate what Aauth does
    $salt = md5($uid);
    $calculated = hash('sha256', $salt . $raw);
    
    echo "User ID: $uid\n";
    echo "Raw Pass: $raw\n";
    echo "Salt used: $salt\n";
    echo "DB Hash: $db_pass\n";
    echo "Calculated: $calculated\n";
    echo "Match? : " . ($db_pass === $calculated ? "YES" : "NO") . "\n";
} else {
    echo "User not found.\n";
}
?>
