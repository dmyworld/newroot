<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$hostname ='localhost';
$username ='root';
$password ='';
$database ='newroot';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SHOW TABLES";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<h2>Tables in " . $database . ":</h2><ul>";
    while($row = $result->fetch_row()) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
    
    // Check columns of geopos_timber_bids
    $sql_cols = "SHOW COLUMNS FROM geopos_timber_bids";
    $result_cols = $conn->query($sql_cols);
    if ($result_cols && $result_cols->num_rows > 0) {
        echo "<h2>Columns in geopos_timber_bids:</h2><ul>";
        while($row = $result_cols->fetch_assoc()) {
            echo "<li>" . $row['Field'] . " (" . $row['Type'] . ")</li>";
        }
        echo "</ul>";
    }
} else {
    echo "0 results or error: " . $conn->error;
}
$conn->close();
?>
