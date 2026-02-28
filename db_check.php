<?php
$hostname ='localhost';
$username ='root';
$password ='';
$database ='newroot';

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

function describe($conn, $table) {
    echo "<h3>Table: $table</h3>";
    $res = $conn->query("DESCRIBE $table");
    if ($res) {
        echo "<table border='1'><tr><th>Field</th><th>Type</th></tr>";
        while($row = $res->fetch_assoc()) {
            echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Error: " . $conn->error;
    }
}

describe($conn, 'geopos_users');
describe($conn, 'geopos_timber_standing');
describe($conn, 'geopos_timber_logs');
describe($conn, 'geopos_timber_sawn');
describe($conn, 'geopos_timber_bids');

$conn->close();
?>
