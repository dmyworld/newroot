<?php
$mysqli = new mysqli("localhost", "root", "", "newroot");
if ($mysqli->connect_error) {
    die("Connect Error: " . $mysqli->connect_error);
}

echo "Creating marketplace tables...\n\n";

// 1. Market Requests (Buyers looking to purchase)
$sql1 = "CREATE TABLE IF NOT EXISTS `geopos_market_requests` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `title` varchar(255) NOT NULL,
    `category` varchar(100) DEFAULT NULL,
    `location` varchar(255) DEFAULT NULL,
    `quantity_needed` decimal(10,2) DEFAULT 0,
    `budget_range` varchar(100) DEFAULT NULL,
    `description` text,
    `status` enum('active','closed','fulfilled') DEFAULT 'active',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($mysqli->query($sql1)) {
    echo "✓ Created geopos_market_requests\n";
} else {
    echo "✗ Error creating geopos_market_requests: " . $mysqli->error . "\n";
}

// 2. Worker Profiles (Sellers looking for employment)
$sql2 = "CREATE TABLE IF NOT EXISTS `geopos_worker_profiles` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `display_name` varchar(255) NOT NULL,
    `category_id` int(11) DEFAULT NULL COMMENT 'References geopos_hrm',
    `experience_years` int(11) DEFAULT 0,
    `skills` text COMMENT 'JSON array of skills',
    `hourly_rate` decimal(10,2) DEFAULT 0,
    `availability` enum('available','busy','unavailable') DEFAULT 'available',
    `bio` text,
    `phone` varchar(50) DEFAULT NULL,
    `location` varchar(255) DEFAULT NULL,
    `status` enum('active','inactive') DEFAULT 'active',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_id` (`user_id`),
    KEY `category_id` (`category_id`),
    KEY `availability` (`availability`),
    KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($mysqli->query($sql2)) {
    echo "✓ Created geopos_worker_profiles\n";
} else {
    echo "✗ Error creating geopos_worker_profiles: " . $mysqli->error . "\n";
}

echo "\n✓ Database migration completed!\n";
$mysqli->close();
?>
