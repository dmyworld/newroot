<?php
/**
 * Service Management Database Update - Phase 2
 * Adding commission and price guardrail fields
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'newroot';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database successfully.\n";

    // 1. Update tp_services table
    $sql1 = "ALTER TABLE `tp_services` 
        ADD COLUMN `admin_commission_pc` DECIMAL(5,2) DEFAULT 0.00 AFTER `sub_cat_id`,
        ADD COLUMN `min_price` DECIMAL(16,2) DEFAULT 0.00 AFTER `admin_commission_pc`,
        ADD COLUMN `max_price` DECIMAL(16,2) DEFAULT 0.00 AFTER `min_price`;";

    $pdo->exec($sql1);
    echo "Table 'tp_services' updated with commission and price fields.\n";

    // 2. Create tp_promo_codes table
    $sql2 = "CREATE TABLE IF NOT EXISTS `tp_promo_codes` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `code` varchar(50) NOT NULL,
        `discount_pc` DECIMAL(5,2) DEFAULT 0.00,
        `discount_fixed` DECIMAL(16,2) DEFAULT 0.00,
        `deduct_from_admin` TINYINT(1) DEFAULT 0 COMMENT '1: Deduct from Admin Comm, 0: Deduct from Worker',
        `expiry_date` date DEFAULT NULL,
        `status` TINYINT(1) DEFAULT 1,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `code` (`code`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $pdo->exec($sql2);
    echo "Table 'tp_promo_codes' created.\n";

    // 3. Create tp_surge_logs table
    $sql3 = "CREATE TABLE IF NOT EXISTS `tp_surge_logs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `cat_id` int(11) DEFAULT 0 COMMENT '0: Global',
        `surge_pc` DECIMAL(5,2) NOT NULL,
        `action_by` int(11) NOT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $pdo->exec($sql3);
    echo "Table 'tp_surge_logs' created.\n";

    echo "Database updates for Phase 2 completed successfully.\n";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
