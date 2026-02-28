<?php
$mysqli = new mysqli("localhost", "root", "", "timberpro");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Add status column to geopos_timber_machinery
$sql = "ALTER TABLE geopos_timber_machinery ADD COLUMN status VARCHAR(50) DEFAULT 'available' AFTER location_gps";
if ($mysqli->query($sql) === TRUE) {
    echo "Column 'status' added successfully to geopos_timber_machinery.\n";
} else {
    echo "Error adding column: " . $mysqli->error . "\n";
}

$mysqli->close();
?>
