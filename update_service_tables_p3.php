<?php
/**
 * Service Management Database Update - Phase 3
 * Creating provider management and tracking tables
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'newroot';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database successfully.\n";

    // 1. Create tp_service_providers table
    $sql1 = "CREATE TABLE IF NOT EXISTS `tp_service_providers` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL COMMENT 'Maps to geopos_users.id',
        `nic_doc` varchar(255) DEFAULT NULL,
        `license_doc` varchar(255) DEFAULT NULL,
        `cert_doc` varchar(255) DEFAULT NULL,
        `is_online` TINYINT(1) DEFAULT 0,
        `last_active` timestamp NULL DEFAULT NULL,
        `current_lat` DECIMAL(10,8) DEFAULT 0.00000000,
        `current_lng` DECIMAL(11,8) DEFAULT 0.00000000,
        `status` TINYINT(1) DEFAULT 0 COMMENT '0: Pending, 1: Active, 2: Suspended, 3: Rejected',
        `rating_avg` DECIMAL(3,2) DEFAULT 0.00,
        `total_jobs` int(11) DEFAULT 0,
        `total_earnings` DECIMAL(16,2) DEFAULT 0.00,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `user_id` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $pdo->exec($sql1);
    echo "Table 'tp_service_providers' created.\n";

    // 2. Create tp_provider_skills table (many-to-many mapping for worker skills)
    $sql2 = "CREATE TABLE IF NOT EXISTS `tp_provider_skills` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `provider_id` int(11) NOT NULL,
        `service_id` int(11) NOT NULL,
        `fixed_price` DECIMAL(16,2) DEFAULT 0.00 COMMENT 'Worker set price within Admin range',
        PRIMARY KEY (`id`),
        UNIQUE KEY `provider_service` (`provider_id`, `service_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $pdo->exec($sql2);
    echo "Table 'tp_provider_skills' created.\n";

    // 3. Create tp_complaints table
    $sql3 = "CREATE TABLE IF NOT EXISTS `tp_complaints` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `customer_id` int(11) NOT NULL,
        `provider_id` int(11) NOT NULL,
        `request_id` int(11) DEFAULT NULL,
        `subject` varchar(255) NOT NULL,
        `description` text NOT NULL,
        `status` TINYINT(1) DEFAULT 0 COMMENT '0: Open, 1: Resolved, 2: Under Review',
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $pdo->exec($sql3);
    echo "Table 'tp_complaints' created.\n";

    echo "Database updates for Phase 3 completed successfully.\n";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
