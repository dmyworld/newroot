<?php
// Simple script to check table structure
// Simulating CodeIgniter logic roughly or just raw PHP
include 'application/config/database.php';
$db = $db['default'];

$conn = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

echo "--- geopos_employees columns ---\n";
$result = $conn->query("SHOW COLUMNS FROM geopos_employees");
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}

echo "\n--- geopos_hrm structure ---\n";
// naming might be geopos_hrm or geopos_hrs. Let's check tables.
$result = $conn->query("SHOW TABLES LIKE 'geopos_hr%'");
while($row = $result->fetch_array()) {
    echo "Table: " . $row[0] . "\n";
    $cols = $conn->query("SHOW COLUMNS FROM " . $row[0]);
    while($c = $cols->fetch_assoc()) {
        echo "  " . $c['Field'] . " - " . $c['Type'] . "\n";
    }
    // Content sample
    echo "  SAMPLE DATA:\n";
    $sample = $conn->query("SELECT * FROM " . $row[0] . " LIMIT 3");
    while($r = $sample->fetch_assoc()) {
        print_r($r);
    }
}
?>
