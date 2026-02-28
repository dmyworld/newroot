<?php
// Direct connection without CodeIgniter context
$hostname ='localhost';
$username ='root';
$password ='';
$database ='newroot';

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SHOW TABLES";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Tables in " . $database . ":</h2><ul>";
    while($row = $result->fetch_row()) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
} else {
    echo "0 results";
}
$conn->close();
?>
