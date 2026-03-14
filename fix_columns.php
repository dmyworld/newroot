<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'c:/Users/user/Documents/GitHub/www/newroot/system/');
define('APPPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/');

require_once(APPPATH . 'config/database.php');
$db_config = $db['default'];

$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add receipt_image to geopos_users
$sql = "SHOW COLUMNS FROM geopos_users LIKE 'receipt_image'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $sql_alter = "ALTER TABLE geopos_users ADD COLUMN receipt_image VARCHAR(255) NULL AFTER subscription_status;";
    if ($conn->query($sql_alter) === TRUE) {
        echo "Column receipt_image added to geopos_users\n";
    } else {
        echo "Error adding column receipt_image: " . $conn->error . "\n";
    }
} else {
    echo "Column receipt_image already exists in geopos_users\n";
}

$conn->close();
?>
