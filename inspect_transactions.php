<?php
header('Content-Type: text/plain');
$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

echo "--- geopos_transactions Structure ---\n";
$res = $conn->query("DESCRIBE geopos_transactions");
while($row = $res->fetch_assoc()) {
    echo "{$row['Field']} | {$row['Type']} | {$row['Null']} | {$row['Key']} | {$row['Default']}\n";
}

echo "\n--- Sample Data Row ---\n";
$res = $conn->query("SELECT * FROM geopos_transactions WHERE id = 42");
print_r($res->fetch_assoc());

$conn->close();
?>
