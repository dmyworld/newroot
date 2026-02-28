<?php
header('Content-Type: text/plain');
$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);

echo "--- Testing Cash in Hand Aggregation ---\n";

$sql = "SELECT id, holder, lastbal, loc FROM geopos_accounts 
        WHERE account_type = 'Assets' 
        AND (holder LIKE '%Cash%' OR holder LIKE '%Petty Cash%')
        AND loc = 0";
$res = $conn->query($sql);
echo "SQL: $sql\n";
echo "Rows Found: " . $res->num_rows . "\n";
while($row = $res->fetch_assoc()) {
    echo "  ID: {$row['id']} | Holder: {$row['holder']} | Bal: {$row['lastbal']}\n";
}

$sql_bank = "SELECT id, holder, lastbal, loc FROM geopos_accounts 
        WHERE account_type = 'Assets' 
        AND (holder LIKE '%Bank%')
        AND loc = 0";
$res = $conn->query($sql_bank);
echo "\nSQL Bank: $sql_bank\n";
echo "Rows Found: " . $res->num_rows . "\n";
while($row = $res->fetch_assoc()) {
    echo "  ID: {$row['id']} | Holder: {$row['holder']} | Bal: {$row['lastbal']}\n";
}

$conn->close();
?>
