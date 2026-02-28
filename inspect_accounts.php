<?php
header('Content-Type: text/plain');
$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

echo "--- geopos_accounts Structure ---\n";
$res = $conn->query("DESCRIBE geopos_accounts");
while($row = $res->fetch_assoc()) {
    echo "{$row['Field']} | {$row['Type']} | {$row['Null']} | {$row['Key']} | {$row['Default']}\n";
}

$conn->close();
?>
