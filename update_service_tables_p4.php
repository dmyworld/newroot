<?php
/**
 * Service Management Database Update - Phase 4
 * Support for KYC metadata, verification logs, and financial audit tray
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'newroot';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database successfully.\n";

    // 1. Update tp_service_providers table for KYC tracking
    $sql1 = "ALTER TABLE `tp_service_providers` 
        ADD COLUMN `kyc_expiry` DATE NULL AFTER `status`,
        ADD COLUMN `kyc_approved_at` DATETIME NULL AFTER `kyc_expiry`,
        ADD COLUMN `kyc_approved_by` INT(11) NULL AFTER `kyc_approved_at`,
        ADD COLUMN `is_verified` TINYINT(1) DEFAULT 0 AFTER `kyc_approved_by`;";

    $pdo->exec($sql1);
    echo "Table 'tp_service_providers' updated for KYC.\n";

    // 2. Create tp_kyc_logs table
    $sql2 = "CREATE TABLE IF NOT EXISTS `tp_kyc_logs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `provider_id` int(11) NOT NULL,
        `admin_id` int(11) NOT NULL,
        `action` varchar(50) NOT NULL COMMENT 'approved, rejected, document_updated',
        `comments` text,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $pdo->exec($sql2);
    echo "Table 'tp_kyc_logs' created.\n";

    // 3. Create tp_finance_audit table
    $sql3 = "CREATE TABLE IF NOT EXISTS `tp_finance_audit` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `service_id` int(11) NOT NULL,
        `field_name` varchar(50) NOT NULL COMMENT 'admin_commission_pc, min_price, max_price',
        `old_value` varchar(255) DEFAULT NULL,
        `new_value` varchar(255) DEFAULT NULL,
        `action_by` int(11) NOT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $pdo->exec($sql3);
    echo "Table 'tp_finance_audit' created.\n";

    echo "Database updates for Phase 4 completed successfully.\n";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
