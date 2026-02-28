<?php
// Connect to DB
$mysqli = new mysqli("localhost", "root", "", "newroot");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$result = $mysqli->query("SELECT * FROM aauth_groups WHERE name IN ('buyer', 'seller')");

while ($row = $result->fetch_assoc()) {
    echo "Group: " . $row['name'] . " - ID: " . $row['id'] . "\n";
}

$mysqli->close();
?>
