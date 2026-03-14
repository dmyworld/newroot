<?php
define('BASEPATH', dirname(__DIR__) . '/system/');
define('APPPATH', dirname(__DIR__) . '/application/');
define('VIEWPATH', dirname(__DIR__) . '/application/views/');
define('ENVIRONMENT', 'development');

require_once APPPATH . 'config/database.php';

$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Ensure locations exist
$mysqli->query("INSERT IGNORE INTO geopos_locations (id, cname) VALUES (1, 'Main Branch'), (2, 'North Branch'), (3, 'South Branch')");

// Create Business Owner user
$email = "owner@example.com";
$password = password_hash("password123", PASSWORD_DEFAULT);

$mysqli->query("DELETE FROM geopos_users WHERE email='$email'");

$stmt = $mysqli->prepare("INSERT INTO geopos_users (email, pass, username, roleid, loc, banned) VALUES (?, ?, 'owner', 5, 1, 0)");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$user_id = $stmt->insert_id;

// Insert Employee record
$mysqli->query("DELETE FROM geopos_employees WHERE id=$user_id");
$mysqli->query("INSERT INTO geopos_employees (id, username, name, salary) VALUES ($user_id, 'owner', 'Test Business Owner', 5000)");

// Assign locations 1, 2, 3
$mysqli->query("DELETE FROM geopos_user_locations WHERE user_id=$user_id");
$mysqli->query("INSERT INTO geopos_user_locations (user_id, location_id) VALUES ($user_id, 1), ($user_id, 2), ($user_id, 3)");

echo "Business Owner created successfully. Email: owner@example.com, Password: password123, Locations: 1, 2, 3\n";

$mysqli->close();
?>
