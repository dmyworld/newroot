<?php
/**
 * Web-based Database Migration Runner for migration_v2.sql
 */

define('BASEPATH', 'dummy');
define('ENVIRONMENT', 'development');
require_once 'application/config/database.php';

$db_config = $db['default'];

$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql_file = 'migration_v2.sql';
if (!file_exists($sql_file)) {
    die("Migration file $sql_file not found.");
}

$sql = file_get_contents($sql_file);

/* execute multi query */
echo "<h3>Running Migration: $sql_file</h3>";
if ($mysqli->multi_query($sql)) {
    do {
        /* store first result set */
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
        /* print divider */
        if ($mysqli->more_results()) {
            // echo "-----------------\n";
        }
    } while ($mysqli->next_result());
    echo "<p style='color:green;'>Success: Migration completed successfully.</p>";
} else {
    echo "<p style='color:red;'>Error: " . $mysqli->error . "</p>";
}

$mysqli->close();
?>
