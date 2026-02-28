<?php
$mysqli = new mysqli("localhost", "root", "", "newroot");
if ($mysqli->connect_error) {
    die("Connect Error: " . $mysqli->connect_error);
}

echo "=== MARKETPLACE V2 ENHANCEMENTS ===\n\n";

// 1. Worker Ratings Table
$sql1 = "CREATE TABLE IF NOT EXISTS `geopos_worker_ratings` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `worker_id` int(11) NOT NULL,
    `buyer_id` int(11) NOT NULL,
    `rating` tinyint(1) NOT NULL CHECK (rating >= 1 AND rating <= 5),
    `review` text,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `worker_id` (`worker_id`),
    KEY `buyer_id` (`buyer_id`),
    UNIQUE KEY `unique_rating` (`worker_id`, `buyer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($mysqli->query($sql1)) {
    echo "✓ Created geopos_worker_ratings\n";
} else {
    echo "✗ Error creating geopos_worker_ratings: " . $mysqli->error . "\n";
}

// 2. Add photo and rating fields to worker_profiles
$sql2 = "ALTER TABLE `geopos_worker_profiles` 
    ADD COLUMN `photo` varchar(255) DEFAULT NULL AFTER `location`,
    ADD COLUMN `average_rating` decimal(3,2) DEFAULT 0.00 AFTER `photo`,
    ADD COLUMN `total_ratings` int(11) DEFAULT 0 AFTER `average_rating`;";

if ($mysqli->query($sql2)) {
    echo "✓ Added photo, average_rating, total_ratings to geopos_worker_profiles\n";
} else {
    // Check if columns already exist
    $check = $mysqli->query("SHOW COLUMNS FROM geopos_worker_profiles LIKE 'photo'");
    if ($check->num_rows > 0) {
        echo "ℹ Photo columns already exist in geopos_worker_profiles\n";
    } else {
        echo "✗ Error modifying geopos_worker_profiles: " . $mysqli->error . "\n";
    }
}

echo "\n✅ Database migration completed!\n";
$mysqli->close();
?>
