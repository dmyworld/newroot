<?php
define('BASEPATH', TRUE);
require_once __DIR__ . '/application/config/database.php';

$conn = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT id, payer, method, type, cat, ext FROM geopos_transactions WHERE payer LIKE '%Payroll Run%' ORDER BY id DESC LIMIT 10");

echo "<h3>Recent Payroll Transactions</h3>\n<pre>\n";
echo sprintf("%-5s %-30s %-12s %-12s %-15s %s\n", "ID", "Payer", "Method", "Type", "Category", "Ext");
echo str_repeat("-", 100) . "\n";

while ($row = $result->fetch_assoc()) {
    echo sprintf("%-5s %-30s %-12s %-12s %-15s %s\n", 
        $row['id'],
        substr($row['payer'], 0, 30),
        $row['method'] ?: 'NULL',
        $row['type'] ?:'NULL',
        $row['cat'] ?: 'NULL',
        $row['ext'] ?: 'NULL'
    );
}

echo "</pre>";
$conn->close();
?>
