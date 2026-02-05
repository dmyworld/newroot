<?php
define('BASEPATH', 'test');
define('ENVIRONMENT', 'development');
include('application/config/database.php');
$config = $db['default'];

$mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "<h2>Checking Payroll Data</h2>";

// Count Employees
$res = $mysqli->query("SELECT COUNT(*) as c FROM geopos_employees");
$row = $res->fetch_assoc();
echo "Employees: " . $row['c'] . "<br>";

// Count Timesheets
$res = $mysqli->query("SELECT COUNT(*) as c FROM geopos_timesheets");
if($res) {
    $row = $res->fetch_assoc();
    echo "Timesheets: " . $row['c'] . "<br>";
} else {
    echo "Timesheets Table Missing?<br>";
}

// Check if Timesheets has 'is_overtime' column (used in calc)
$res = $mysqli->query("SHOW COLUMNS FROM geopos_timesheets LIKE 'is_overtime'");
if ($res->num_rows == 0) {
    echo "WARNING: is_overtime column missing in geopos_timesheets!<br>";
}

// Check if geopos_employee_loans exists
$res = $mysqli->query("SHOW TABLES LIKE 'geopos_employee_loans'");
if ($res->num_rows == 0) {
    echo "WARNING: geopos_employee_loans table missing!<br>";
}

$mysqli->close();
?>
