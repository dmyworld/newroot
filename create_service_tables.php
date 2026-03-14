<?php
/**
 * Service Management Database Setup
 * Created for Phase 1: Admin Setup
 */

// Include CodeIgniter's database connection logic from index.php if possible
// For standalone scripts, we often use a simplified version or a migration runner.
// Since I can't easily run CodeIgniter's internal migrations via shell here without more setup, 
// I will create a script that uses raw PHP PDO to create the tables.

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'newroot'; // Based on directory name and common practice

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database successfully.\n";

    // 1. tp_service_categories table
    $sql1 = "CREATE TABLE IF NOT EXISTS `tp_service_categories` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `extra` text DEFAULT NULL,
        `icon` varchar(255) DEFAULT NULL,
        `c_type` int(1) DEFAULT 0 COMMENT '0: Main, 1: Sub',
        `rel_id` int(11) DEFAULT 0 COMMENT 'Parent ID if Sub',
        `status` int(1) DEFAULT 1,
        `requested_by` int(11) DEFAULT NULL,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $pdo->exec($sql1);
    echo "Table 'tp_service_categories' created or already exists.\n";

    // 2. tp_services table
    $sql2 = "CREATE TABLE IF NOT EXISTS `tp_services` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `service_name` varchar(255) NOT NULL,
        `service_desc` text DEFAULT NULL,
        `cat_id` int(11) NOT NULL,
        `sub_cat_id` int(11) DEFAULT 0,
        `status` int(1) DEFAULT 1 COMMENT '1: Active, 0: Inactive',
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `cat_id` (`cat_id`),
        KEY `sub_cat_id` (`sub_cat_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $pdo->exec($sql2);
    echo "Table 'tp_services' created or already exists.\n";

    echo "Database setup completed successfully.\n";

} catch (PDOException $e) {
    die("Error: Could not connect. " . $e->getMessage());
}
