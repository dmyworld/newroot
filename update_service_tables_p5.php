<?php
/**
 * Service Management Database Update - Phase 5
 * Creating service request and payout tables
 */

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'newroot';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database successfully.\n";

    // 1. Create tp_service_requests table
    $sql1 = "CREATE TABLE IF NOT EXISTS `tp_service_requests` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `customer_id` int(11) NOT NULL,
        `service_id` int(11) NOT NULL,
        `provider_id` int(11) DEFAULT NULL,
        `status` TINYINT(1) DEFAULT 0 COMMENT '0: Requested, 1: Pending Acceptance, 2: Accepted/Enroute, 3: Ongoing, 4: Completed, 5: Cancelled',
        `pickup_lat` DECIMAL(10,8) DEFAULT NULL,
        `pickup_lng` DECIMAL(11,8) DEFAULT NULL,
        `pickup_address` TEXT DEFAULT NULL,
        `agreed_price` DECIMAL(16,2) DEFAULT 0.00,
        `admin_commission` DECIMAL(16,2) DEFAULT 0.00,
        `worker_share` DECIMAL(16,2) DEFAULT 0.00,
        `otp_code` varchar(4) DEFAULT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        `accepted_at` timestamp NULL DEFAULT NULL,
        `started_at` timestamp NULL DEFAULT NULL,
        `completed_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $pdo->exec($sql1);
    echo "Table 'tp_service_requests' created.\n";

    // 2. Create tp_withdrawal_requests table
    $sql2 = "CREATE TABLE IF NOT EXISTS `tp_withdrawal_requests` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `provider_id` int(11) NOT NULL,
        `amount` DECIMAL(16,2) NOT NULL,
        `bank_info` text NOT NULL,
        `status` TINYINT(1) DEFAULT 0 COMMENT '0: Pending, 1: Approved, 2: Rejected',
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        `processed_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $pdo->exec($sql2);
    echo "Table 'tp_withdrawal_requests' created.\n";

    // 3. Modify tp_service_providers to add fcm_token
    $sql3 = "ALTER TABLE `tp_service_providers` ADD COLUMN `fcm_token` VARCHAR(255) DEFAULT NULL;";
    try {
        $pdo->exec($sql3);
        echo "Table 'tp_service_providers' updated with fcm_token.\n";
    } catch (PDOException $e) {
        // Ignore if column already exists
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "Column 'fcm_token' already exists.\n";
        } else {
            throw $e;
        }
    }

    echo "Database updates for Phase 5 completed successfully.\n";

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
