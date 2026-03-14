<?php
// Define constants to allow CI core to load
define('ENVIRONMENT', 'development');
define('BASEPATH', 'c:/Users/user/Documents/GitHub/www/newroot/system/');
define('APPPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/');
define('VIEWPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/views/');

// Load the database configuration
require_once(APPPATH . 'config/database.php');
$config = $db['default'];

$conn = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Aauth hashing configuration (extracted from application/config/aauth.php)
$hash_algo = 'sha256';

$demo_users = [
    ['username' => 'demo_customer', 'email' => 'customer@demo.lk', 'role_id' => 13],
    ['username' => 'demo_owner', 'email' => 'owner@demo.lk', 'role_id' => 5],
    ['username' => 'demo_provider', 'email' => 'provider@demo.lk', 'role_id' => 12]
];

$password = 'demo123';

foreach ($demo_users as $user) {
    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM geopos_users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $user['email'], $user['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        // Initial insert with dummy password (Aauth pattern)
        $stmt_ins = $conn->prepare("INSERT INTO geopos_users (email, pass, username, banned, last_login, roleid, loc, picture) VALUES (?, '', ?, 0, NOW(), ?, 1, 'example.png')");
        $stmt_ins->bind_param("ssi", $user['email'], $user['username'], $user['role_id']);
        $stmt_ins->execute();
        $user_id = $stmt_ins->insert_id;
        
        // Generate accurate hash using Aauth logic: hash(sha256, md5(userid) + password)
        $salt = md5($user_id);
        $final_hash = hash($hash_algo, $salt . $password);
        
        // Update with correct hash
        $stmt_upd = $conn->prepare("UPDATE geopos_users SET pass = ? WHERE id = ?");
        $stmt_upd->bind_param("si", $final_hash, $user_id);
        $stmt_upd->execute();
        
        // Add to employees
        $stmt_emp = $conn->prepare("INSERT INTO geopos_employees (id, username, name, phone, address, city, region, country, postbox) VALUES (?, ?, ?, '0771234567', '', '', '', '', '')");
        $stmt_emp->bind_param("iss", $user_id, $user['username'], $user['username']);
        $stmt_emp->execute();
        
        echo "Created demo user: " . $user['username'] . " (ID: $user_id)\n";
    } else {
        // User exists, just update password to be sure
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        $salt = md5($user_id);
        $final_hash = hash($hash_algo, $salt . $password);
        
        $stmt_upd = $conn->prepare("UPDATE geopos_users SET pass = ? WHERE id = ?");
        $stmt_upd->bind_param("si", $final_hash, $user_id);
        $stmt_upd->execute();
        
        echo "Reset password for existing demo user: " . $user['username'] . "\n";
    }
}

$conn->close();
?>
