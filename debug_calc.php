<?php
// Debug Calculation Logic
// Access: http://localhost/newroot/debug_calc.php

define('BASEPATH', 'TRUE'); // Fake CI constant
date_default_timezone_set('UTC');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newroot";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

echo "<h1>Payroll Calculation Debugger</h1>";

$emp_id = 1; // Testing with Employee 1
$start = '2026-01-25'; // Adjust to cover recent timesheets
$end = '2026-02-05';

echo "<h3>1. Checking Employee $emp_id</h3>";
$res = $conn->query("SELECT id, name, salary FROM geopos_employees WHERE id = $emp_id");
if($row = $res->fetch_assoc()) {
    echo "Found: {$row['name']} | Salary Rate: " . ($row['salary'] ? $row['salary'] : 'NULL/0') . "<br>";
    if($row['salary'] <= 0) echo "⚠️ ARTIFACT: Salary is zero! Fix this first.<br>";
} else {
    echo "❌ Employee not found.<br>";
}

echo "<h3>2. Checking Timesheets ($start to $end)</h3>";
// Check what columns we actually have
$cols = $conn->query("SHOW COLUMNS FROM geopos_timesheets");
$col_names = [];
echo "Columns in geopos_timesheets: ";
while($c = $cols->fetch_assoc()) { echo $c['Field'] . ", "; $col_names[] = $c['Field']; }
echo "<br>";

$date_col = in_array('date', $col_names) ? 'date' : (in_array('clock_in', $col_names) ? 'clock_in' : 'id');
echo "Using date column: <b>$date_col</b><br>";

// Query timesheets
$sql = "SELECT * FROM geopos_timesheets WHERE employee_id = $emp_id"; 
// Note: simplified query to see ALL entries for this user first
$ts_res = $conn->query($sql);
$total_hours = 0;
echo "<table border=1><tr><th>ID</th><th>Date/ClockIn</th><th>Hours</th><th>Status</th></tr>";
while($row = $ts_res->fetch_assoc()) {
    $d_val = isset($row[$date_col]) ? $row[$date_col] : 'N/A';
    $h = $row['total_hours'];
    
    // Check if within range
    $in_range = ($d_val >= $start && $d_val <= $end) ? "✅" : "outside range";
    
    echo "<tr><td>{$row['id']}</td><td>$d_val</td><td>$h</td><td>$in_range</td></tr>";
    
    if($d_val >= $start && $d_val <= $end) {
        $total_hours += $h;
    }
}
echo "</table>";
echo "<b>Calculated Total Hours in Range: $total_hours</b><br>";

echo "<h3>3. Projected Calculation</h3>";
if(isset($row['salary'])) {
    $gross = $total_hours * $row['salary'];
    echo "Rate: {$row['salary']} * Hours: $total_hours = <b>$gross</b>";
}

$conn->close();
?>
