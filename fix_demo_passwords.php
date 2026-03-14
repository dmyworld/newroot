<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'c:/Users/user/Documents/GitHub/www/newroot/system/');
define('APPPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/');

require_once(APPPATH . 'config/database.php');
require_once(APPPATH . 'config/aauth.php');
$db_config = $db['default'];
$aauth_vars = $config['aauth'];

$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$demo_users = ['customer@demo.lk', 'owner@demo.lk', 'provider@demo.lk'];
$password = 'demo123';

foreach ($demo_users as $email) {
    $result = $conn->query("SELECT id FROM geopos_users WHERE email = '$email'");
    if ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        
        // Accurate recreation of Aauth::hash_password logic
        $salt = md5($id);
        $hashed = hash('sha256', $salt . $password);
        
        $conn->query("UPDATE geopos_users SET pass = '$hashed' WHERE id = $id");
        echo "Updated password for $email (ID: $id)\n";
    } else {
        echo "User not found: $email\n";
    }
}

$conn->close();
?>
