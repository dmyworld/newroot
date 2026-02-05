<?php
define('BASEPATH', 'test'); // Dummy definition to bypass check
define('ENVIRONMENT', 'development');

// Load database config
include('application/config/database.php');
$config = $db['default'];

$mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// User details
$username = 'demoadmin';
$email = 'admin@demo.com';
$password_plain = 'password123';
$roleid = 5; // Business Owner
$loc = 1; // Default location

// Check if user exists
$res = $mysqli->query("SELECT id FROM geopos_users WHERE email = '$email'");
if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $user_id = $row['id'];
    echo "User already exists with ID $user_id. Resetting password...<br>";
} else {
    // 1. Insert User (dummy pass first)
    $sql = "INSERT INTO geopos_users (email, pass, username, roleid, loc, banned, totp_secret) VALUES ('$email', 'dummy', '$username', $roleid, $loc, 0, NULL)";
    if ($mysqli->query($sql)) {
        $user_id = $mysqli->insert_id;
        echo "User created with ID: $user_id<br>";
    } else {
        die("Error inserting user: " . $mysqli->error);
    }
}

// 2. Hash Password
// Aauth: hash('sha256', md5($userid) . $pass);
$salt = md5($user_id);
$pass_hash = hash('sha256', $salt . $password_plain);

$mysqli->query("UPDATE geopos_users SET pass = '$pass_hash' WHERE id = $user_id");
echo "Password updated.<br>";

// 3. Insert/Update Employee Profile
$name = 'Demo Admin';
$phone = '123456789';
$address = 'Demo User Address';
$city = 'City';

$res_emp = $mysqli->query("SELECT id FROM geopos_employees WHERE id = $user_id");
if($res_emp->num_rows == 0) {
    $sql_emp = "INSERT INTO geopos_employees (id, name, address, city, phone, email) 
                VALUES ($user_id, '$name', '$address', '$city', '$phone', '$email')";
                
    if($mysqli->query($sql_emp)) {
        echo "Employee profile created.<br>";
    } else {
        echo "Error creating employee profile: " . $mysqli->error . "<br>";
    }
} else {
    echo "Employee profile already exists.<br>";
}

echo "<h1>DONE</h1>";
echo "Login: $email<br>";
echo "Password: $password_plain<br>";

$mysqli->close();
?>
