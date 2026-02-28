<?php
$conn = new mysqli("localhost", "root", "", "newroot");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$res = $conn->query("SELECT holder, account_type, lastbal FROM geopos_accounts LIMIT 20");
echo "Account | Type | Balance\n";
while($row = $res->fetch_assoc()) {
    echo $row['holder'] . " | " . $row['account_type'] . " | " . $row['lastbal'] . "\n";
}
$conn->close();
