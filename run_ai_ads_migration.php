<?php
define('BASEPATH', 'dummy');
define('ENVIRONMENT', 'development');
require_once 'application/config/database.php';

$db_config = $db['default'];
$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function addColumnIfNotExists($mysqli, $table, $column, $definition, $addIndex = false) {
    $check = $mysqli->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    if($check && $check->num_rows == 0) {
        $sql = "ALTER TABLE `$table` ADD COLUMN `$column` $definition";
        if($mysqli->query($sql)) {
            echo "Added $column to $table.\n";
            if ($addIndex) {
                $mysqli->query("ALTER TABLE `$table` ADD INDEX (`$column`)");
            }
        } else {
            echo "Error adding $column to $table: " . $mysqli->error . "\n";
        }
    } else {
        echo "Column $column already exists in $table.\n";
    }
}

addColumnIfNotExists($mysqli, 'geopos_config', 'fb_profile_id', 'VARCHAR(255) DEFAULT \'\'');
addColumnIfNotExists($mysqli, 'geopos_config', 'access_token', 'TEXT DEFAULT NULL');

// 2. Add Configuration slot for Revid AI
$sql1 = "INSERT INTO `geopos_config` (`id`, `fb_profile_id`, `access_token`) VALUES (13, '', '') 
ON DUPLICATE KEY UPDATE `fb_profile_id` = `fb_profile_id`;";

if($mysqli->query($sql1)) {
    echo "Initialized Revid AI config slot.\n";
} else {
    echo "Error initializing config: " . $mysqli->error . "\n";
}

addColumnIfNotExists($mysqli, 'geopos_timber_logs', 'revid_video_url', 'VARCHAR(255) DEFAULT NULL', true);
addColumnIfNotExists($mysqli, 'geopos_timber_standing', 'revid_video_url', 'VARCHAR(255) DEFAULT NULL', true);
addColumnIfNotExists($mysqli, 'geopos_timber_sawn', 'revid_video_url', 'VARCHAR(255) DEFAULT NULL', true);
addColumnIfNotExists($mysqli, 'geopos_timber_machinery', 'revid_video_url', 'VARCHAR(255) DEFAULT NULL', true);

echo "AI Ads Migration completed.\n";
$mysqli->close();
?>
