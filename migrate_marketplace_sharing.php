<?php
$mysqli = new mysqli("localhost", "root", "", "newroot");
if ($mysqli->connect_error) {
    die("Connect Error: " . $mysqli->connect_error);
}

echo "=== MARKETPLACE SHARE TRACKING SETUP ===\n\n";

// 1. Marketplace Shares Table
$sql1 = "CREATE TABLE IF NOT EXISTS `geopos_marketplace_shares` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `listing_id` int(11) NOT NULL,
    `listing_type` varchar(20) NOT NULL COMMENT 'logs, standing, sawn',
    `user_id` int(11) DEFAULT NULL,
    `platform` varchar(50) NOT NULL COMMENT 'facebook, twitter, linkedin, whatsapp, telegram, email',
    `share_url` varchar(255) DEFAULT NULL,
    `clicks` int(11) DEFAULT 0,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `listing_id` (`listing_id`),
    KEY `user_id` (`user_id`),
    KEY `platform` (`platform`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($mysqli->query($sql1)) {
    echo "✓ Created geopos_marketplace_shares\n";
} else {
    echo "✗ Error creating geopos_marketplace_shares: " . $mysqli->error . "\n";
}

// 2. Marketplace Settings Table
$sql2 = "CREATE TABLE IF NOT EXISTS `geopos_marketplace_settings` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `auto_share_enabled` tinyint(1) DEFAULT 0,
    `platforms` text COMMENT 'JSON array of enabled platforms',
    `share_template` text,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($mysqli->query($sql2)) {
    echo "✓ Created geopos_marketplace_settings\n";
} else {
    echo "✗ Error creating geopos_marketplace_settings: " . $mysqli->error . "\n";
}

// 3. Add featured flag to timber tables
$tables = ['geopos_timber_logs', 'geopos_timber_standing', 'geopos_timber_sawn'];
foreach ($tables as $table) {
    $sql = "ALTER TABLE `$table` ADD COLUMN `featured` tinyint(1) DEFAULT 0 AFTER `status`;";
    if ($mysqli->query($sql)) {
        echo "✓ Added featured column to $table\n";
    } else {
        $check = $mysqli->query("SHOW COLUMNS FROM $table LIKE 'featured'");
        if ($check->num_rows > 0) {
            echo "ℹ Featured column already exists in $table\n";
        } else {
            echo "✗ Error modifying $table: " . $mysqli->error . "\n";
        }
    }
}

echo "\n✅ Share tracking setup completed!\n";
$mysqli->close();
?>
