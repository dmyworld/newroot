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

// 1. Create tp_subscriptions table
$sql1 = "CREATE TABLE IF NOT EXISTS tp_subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    plan_id INT NOT NULL COMMENT '1: Free, 2: 15k, 3: 25k',
    status ENUM('pending', 'active', 'expired', 'suspended') DEFAULT 'pending',
    activated_at DATETIME NULL,
    expires_at DATETIME NULL,
    last_reminder_sent DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if ($conn->query($sql1) === TRUE) {
    echo "Table tp_subscriptions created successfully\n";
} else {
    echo "Error creating table tp_subscriptions: " . $conn->error . "\n";
}

// 2. Create tp_commission_logs table
$sql2 = "CREATE TABLE IF NOT EXISTS tp_commission_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('paid', 'unpaid') DEFAULT 'unpaid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if ($conn->query($sql2) === TRUE) {
    echo "Table tp_commission_logs created successfully\n";
} else {
    echo "Error creating table tp_commission_logs: " . $conn->error . "\n";
}

// 3. Alter geopos_users
$sql_check = "SHOW COLUMNS FROM geopos_users LIKE 'is_verified'";
$result = $conn->query($sql_check);
if ($result->num_rows == 0) {
    $sql3 = "ALTER TABLE geopos_users ADD COLUMN is_verified TINYINT(1) DEFAULT 0 AFTER business_id;";
    if ($conn->query($sql3) === TRUE) {
        echo "Column is_verified added to geopos_users\n";
    } else {
        echo "Error adding column is_verified: " . $conn->error . "\n";
    }
} else {
    echo "Column is_verified already exists in geopos_users\n";
}

$conn->close();
?>
