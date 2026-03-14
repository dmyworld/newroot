<?php
define('BASEPATH', 'dummy');
define('ENVIRONMENT', 'development');
require_once 'application/config/database.php';

$db_config = $db['default'];
$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// 1. Create packages table
$sql1 = "
CREATE TABLE IF NOT EXISTS `geopos_packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `location_limit` int(11) NOT NULL DEFAULT '1',
  `commission_rate` decimal(5,2) NOT NULL DEFAULT '0.00',
  `ai_ads_limit` int(11) NOT NULL DEFAULT '0',
  `delete_status` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if($mysqli->query($sql1)) {
    echo "Created geopos_packages table.\n";
} else {
    echo "Error: " . $mysqli->error . "\n";
}

$sql2 = "INSERT INTO `geopos_packages` (`id`, `package_name`, `price`, `location_limit`, `commission_rate`, `ai_ads_limit`) 
VALUES
(1, 'Starter', 0.00, 1, 3.00, 0),
(2, 'Standard', 15000.00, 1, 0.00, 2),
(3, 'Professional', 25000.00, 5, 0.00, 4)
ON DUPLICATE KEY UPDATE `package_name`=VALUES(`package_name`);";
$mysqli->query($sql2);

// Function to add column
function addColumnIfNotExists($mysqli, $table, $column, $definition) {
    if (!$mysqli->query("DESCRIBE `$table`")) {
        echo "Table $table does not exist.\n";
        return;
    }
    $check = $mysqli->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    if($check->num_rows == 0) {
        $sql = "ALTER TABLE `$table` ADD COLUMN `$column` $definition";
        if($mysqli->query($sql)) {
            echo "Added $column to $table.\n";
        } else {
            echo "Error adding $column to $table: " . $mysqli->error . "\n";
        }
    } else {
        echo "Column $column already exists in $table.\n";
    }
}

addColumnIfNotExists($mysqli, 'geopos_users', 'delete_status', 'TINYINT(1) NOT NULL DEFAULT 0');
addColumnIfNotExists($mysqli, 'geopos_users', 'package_id', 'INT(11) NOT NULL DEFAULT 1');
addColumnIfNotExists($mysqli, 'geopos_employees', 'delete_status', 'TINYINT(1) NOT NULL DEFAULT 0');
addColumnIfNotExists($mysqli, 'geopos_locations', 'delete_status', 'TINYINT(1) NOT NULL DEFAULT 0');
addColumnIfNotExists($mysqli, 'geopos_customers', 'delete_status', 'TINYINT(1) NOT NULL DEFAULT 0');
addColumnIfNotExists($mysqli, 'geopos_products', 'delete_status', 'TINYINT(1) NOT NULL DEFAULT 0');
addColumnIfNotExists($mysqli, 'geopos_invoices', 'delete_status', 'TINYINT(1) NOT NULL DEFAULT 0');

echo "Migration completed.\n";
$mysqli->close();
?>
