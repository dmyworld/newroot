<?php
// Debug Payroll Data
// Access: http://localhost/newroot/debug_payroll.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newroot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

echo "<h3>Payroll Runs</h3>";
$res = $conn->query("SELECT * FROM geopos_payroll_runs");
if($res->num_rows > 0) {
    echo "<table border=1><tr><th>ID</th><th>Start</th><th>End</th><th>Total</th><th>Status</th></tr>";
    while($row = $res->fetch_assoc()) {
        echo "<tr><td>{$row['id']}</td><td>{$row['start_date']}</td><td>{$row['end_date']}</td><td>{$row['total_amount']}</td><td>{$row['status']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "No Runs Found.<br>";
}

echo "<h3>Payroll Items</h3>";
$res = $conn->query("SELECT * FROM geopos_payroll_items LIMIT 5");
if($res->num_rows > 0) {
    echo "<table border=1><tr><th>ID</th><th>Run ID</th><th>Emp ID</th><th>Net Pay</th><th>Deductions JSON</th></tr>";
    while($row = $res->fetch_assoc()) {
        echo "<tr><td>{$row['id']}</td><td>{$row['run_id']}</td><td>{$row['employee_id']}</td><td>{$row['net_pay']}</td><td>" . htmlspecialchars($row['deduction_details']) . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No Items Found.<br>";
}

$conn->close();
?>
