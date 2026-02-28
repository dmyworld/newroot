<?php
$conn = new mysqli("localhost", "root", "", "newroot");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$res = $conn->query("DESCRIBE geopos_accounts");
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
$conn->close();
