<?php
/**
 * Database Migration Script for Project Command Center
 */

define('BASEPATH', 'dummy');
define('ENVIRONMENT', 'development'); // Fix for ENVIRONMENT constant
require_once 'application/config/database.php';

$db_config = $db['default'];

$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = file_get_contents('application/migrations/tp_command_center_tables.sql');

/* execute multi query */
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
    echo "Success: Project Command Center tables created or already exist.\n";
} else {
    echo "Error: " . $mysqli->error . "\n";
}

$mysqli->close();
?>
