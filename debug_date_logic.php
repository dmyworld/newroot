<?php
header('Content-Type: text/plain');
$host = 'localhost'; $user = 'root'; $pass = ''; $dbname = 'newroot';
$conn = new mysqli($host, $user, $pass, $dbname);

$start_date = date('Y-m-01');
$end_date = date('Y-m-d');

echo "Start: "; var_export($start_date); echo "\n";
echo "End:   "; var_export($end_date); echo "\n";

$res = $conn->query("SELECT id, date FROM geopos_transactions WHERE id = 42");
$row = $res->fetch_assoc();
$d = $row['date'];
echo "Row 42 Date: "; var_export($d); echo "\n";

echo "Is \$d >= \$start_date? " . ($d >= $start_date ? 'YES' : 'NO') . "\n";
echo "Is \$d <= \$end_date?   " . ($d <= $end_date ? 'YES' : 'NO') . "\n";

$conn->close();
?>
