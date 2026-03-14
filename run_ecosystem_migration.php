<?php
/**
 * TimberPro Ecosystem Migration
 * Run this by visiting: http://localhost/newroot/run_ecosystem_migration.php
 */

define('ENVIRONMENT', 'development');
define('BASEPATH', 'dummy');
include 'application/config/database.php';
$db_config = $db['default'];
$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h1>TimberPro Ecosystem Migration</h1>";

$queries = [
    "CREATE TABLE IF NOT EXISTS `tp_subscriptions` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `plan_type` varchar(50) NOT NULL COMMENT 'Free, 15k, 25k',
        `status` enum('active','expired') NOT NULL DEFAULT 'active',
        `start_date` datetime NOT NULL,
        `end_date` datetime NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
    "ALTER TABLE `geopos_users` ADD COLUMN IF NOT EXISTS `package_id` INT(11) NULL DEFAULT NULL AFTER `loc`;",
    "ALTER TABLE `geopos_users` ADD COLUMN IF NOT EXISTS `business_type` ENUM('Hardware', 'Timber', 'Service Provider') NULL DEFAULT NULL AFTER `package_id`;"
];

foreach ($queries as $query) {
    if ($conn->query($query) === TRUE) {
        echo "<p style='color:green'>Success: " . htmlspecialchars(substr($query, 0, 100)) . "...</p>";
    } else {
        echo "<p style='color:red'>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
echo "<h2>Migration Complete. Please delete this file after use.</h2>";
?>
