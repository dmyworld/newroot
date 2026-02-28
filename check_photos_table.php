<?php
// DB Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newroot";

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check for geopos_timber_photos table
$table_name = "geopos_timber_photos";
$result = $mysqli->query("SHOW TABLES LIKE '$table_name'");

if ($result->num_rows > 0) {
    echo "Table '$table_name' exists.\n";
    $res = $mysqli->query("DESCRIBE $table_name");
    echo "\n--- $table_name Schema ---\n";
    while($row = $res->fetch_assoc()) {
        echo "Field: " . $row['Field'] . " - Type: " . $row['Type'] . "\n";
    }
} else {
    echo "Table '$table_name' does NOT exist.\n";
}

$mysqli->close();
?>
