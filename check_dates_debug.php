<?php
header('Content-Type: text/plain');
$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);

echo "--- Current Transactions (IDs 40-46) ---\n";
$res = $conn->query("SELECT id, date, acid FROM geopos_transactions WHERE id BETWEEN 40 AND 46");
while($row = $res->fetch_assoc()) {
    echo "ID: {$row['id']} | Date: [{$row['date']}] | Acid: {$row['acid']}\n";
}

echo "\n--- Attempting Update on ID 42 ---\n";
$server_today = date('Y-m-d');
$conn->query("UPDATE geopos_transactions SET date = '$server_today' WHERE id = 42");
if ($conn->affected_rows > 0) {
    echo "ID 42 updated successfully to $server_today\n";
} else {
    echo "ID 42 update FAILED or already matches.\n";
}

$conn->close();
?>
