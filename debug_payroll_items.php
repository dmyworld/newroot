<?php
// Quick debugging for payroll items table
define('BASEPATH', 'test');
include('application/config/database.php');
$config = $db['default'];

$mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "<h2>Debug Payroll Items Table</h2>";

// Check columns
echo "<h3>Columns in geopos_payroll_items:</h3>";
$result = $mysqli->query("SHOW COLUMNS FROM geopos_payroll_items");
echo "<table border='1' cellpadding='5'><tr><th>Field</th><th>Type</th><th>Null</th><th>Default</th></tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['Field']}</td><td>{$row['Type']}</td><td>{$row['Null']}</td><td>{$row['Default']}</td></tr>";
}
echo "</table>";

// Check if run 12 exists
echo "<h3>Payroll Run 12 Details:</h3>";
$result = $mysqli->query("SELECT * FROM geopos_payroll_runs WHERE id = 12");
if($run = $result->fetch_assoc()) {
    echo "<pre>" . print_r($run, true) . "</pre>";
    
    // Now get items
    echo "<h3>Items for Run 12:</h3>";
    $result = $mysqli->query("SELECT * FROM geopos_payroll_items WHERE run_id = 12");
    echo "Items found: " . $result->num_rows . "<br><br>";
    
    if($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'><tr><th>ID</th><th>Employee ID</th><th>Gross</th><th>Net</th><th>EPF</th><th>Loan</th></tr>";
        while($item = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$item['id']}</td>";
            echo "<td>{$item['employee_id']}</td>";
            echo "<td>" . (isset($item['gross_pay']) ? $item['gross_pay'] : 'N/A') . "</td>";
            echo "<td>" . (isset($item['net_pay']) ? $item['net_pay'] : 'N/A') . "</td>";
            echo "<td>" . (isset($item['epf_employee']) ? $item['epf_employee'] : 'N/A') . "</td>";
            echo "<td>" . (isset($item['loan_deduction']) ? $item['loan_deduction'] : 'N/A') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} else {
    echo "Run 12 not found!";
}

$mysqli->close();
?>
