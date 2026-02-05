<?php
define('BASEPATH', TRUE);
require_once __DIR__ . '/application/config/database.php';

$conn = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Show table structure
echo "<h3>geopos_transactions Table Structure</h3>\n<pre>\n";
$result = $conn->query("DESCRIBE geopos_transactions");
while ($row = $result->fetch_assoc()) {
    echo sprintf("%-20s %-15s %-8s %-8s\n", $row['Field'], $row['Type'], $row['Null'], $row['Key']);
}

echo "\n\n<h3>Recent Payroll Transaction Data</h3>\n";
$result = $conn->query("SELECT id, payer, method, type, cat, ext, note FROM geopos_transactions WHERE payer LIKE '%Payroll Run%' ORDER BY id DESC LIMIT 5");

echo sprintf("%-5s %-30s %-12s %-12s %-15s %-8s %s\n", "ID", "Payer", "Method", "Type", "Category", "Ext", "Note");
echo str_repeat("-", 120) . "\n";

while ($row = $result->fetch_assoc()) {
    echo sprintf("%-5s %-30s %-12s %-12s %-15s %-8s %s\n", 
        $row['id'],
        substr($row['payer'], 0, 30),
        var_export($row['method'], true),
        var_export($row['type'], true),
        var_export($row['cat'], true),
        var_export($row['ext'], true),
        substr($row['note'], 0, 40)
    );
}

echo "</pre>";
$conn->close();
?>
