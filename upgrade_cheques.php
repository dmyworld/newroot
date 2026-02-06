<?php
// Fixed Schema upgrade script for geopos_cheques
$db_hostname = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name     = 'newroot';

try {
    $dsn = "mysql:host=$db_hostname;dbname=$db_name;charset=utf8";
    $pdo = new PDO($dsn, $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h3>Upgrading geopos_cheques Schema...</h3>";

    // 1. Check existing columns
    $stmt = $pdo->query("DESCRIBE geopos_cheques");
    $db_cols = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $sql_alters = [];

    if (!in_array('issue_date', $db_cols)) {
        $sql_alters[] = "ADD COLUMN `issue_date` DATE NULL AFTER `amount`";
    }
    if (!in_array('clear_date', $db_cols)) {
        $sql_alters[] = "ADD COLUMN `clear_date` DATE NULL AFTER `issue_date`";
    }
    if (!in_array('party_id', $db_cols)) {
        $sql_alters[] = "ADD COLUMN `party_id` INT(11) DEFAULT 0 AFTER `status`";
    }
    if (!in_array('party_type', $db_cols)) {
        $sql_alters[] = "ADD COLUMN `party_type` ENUM('Customer','Supplier') DEFAULT 'Customer' AFTER `party_id`";
    }
    if (!in_array('bank', $db_cols)) {
        $sql_alters[] = "ADD COLUMN `bank` VARCHAR(200) DEFAULT NULL AFTER `party_type`";
    }
    if (!in_array('branch', $db_cols)) {
        $sql_alters[] = "ADD COLUMN `branch` VARCHAR(200) DEFAULT NULL AFTER `bank`";
    }

    if (!empty($sql_alters)) {
        $sql = "ALTER TABLE geopos_cheques " . implode(", ", $sql_alters);
        $pdo->exec($sql);
        echo "✓ Table columns added.<br>";
    } else {
        echo "✓ Table already has updated columns.<br>";
    }

    // 2. Data Migration: Copy 'date' to 'issue_date' and 'clear_date' if they are null
    $pdo->exec("UPDATE geopos_cheques SET issue_date = `date` WHERE issue_date IS NULL AND `date` IS NOT NULL");
    $pdo->exec("UPDATE geopos_cheques SET clear_date = `date` WHERE clear_date IS NULL AND `date` IS NOT NULL");
    echo "✓ Data migrated from old columns.<br>";

    echo "<h3 style='color: green;'>✓ Upgrade Successful!</h3>";

} catch (PDOException $e) {
    echo "<h3 style='color: red;'>Error: " . $e->getMessage() . "</h3>";
}
