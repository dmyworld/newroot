<?php
$mysqli = new mysqli("localhost", "root", "", "newroot");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$queries = [
    "ALTER TABLE `consumer_orders` ADD COLUMN `project_id` INT UNSIGNED DEFAULT 0 AFTER `id`",
    "ALTER TABLE `consumer_orders` ADD COLUMN `approval_status` ENUM('not_required', 'pending_owner', 'approved', 'rejected') DEFAULT 'not_required' AFTER `project_id`",
    "ALTER TABLE `geopos_transactions` ADD COLUMN `project_id` INT UNSIGNED DEFAULT 0 AFTER `id`"
];

foreach ($queries as $query) {
    if (!$mysqli->query($query)) {
        echo "Error: " . $mysqli->error . "\n";
    } else {
        echo "Success: " . $query . "\n";
    }
}

$mysqli->close();
?>
