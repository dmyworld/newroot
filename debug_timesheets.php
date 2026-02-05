<?php
// Debug Timesheets Index
// Access: http://localhost/newroot/debug_timesheets.php

define('BASEPATH', 'TRUE'); // Fake
date_default_timezone_set('UTC');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newroot";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

echo "<h1>Debug Timesheets Index</h1>";

// 1. Check Job Codes Query (used in index)
echo "<h3>Testing get_job_codes()</h3>";
$sql = "SELECT * FROM geopos_job_codes WHERE is_active = 1";
$res = $conn->query($sql);

if($res) {
    echo "✅ Job Codes Query Successful. Rows: " . $res->num_rows . "<br>";
    while($row = $res->fetch_assoc()) {
        echo " - " . $row['code'] . ": " . $row['title'] . "<br>";
    }
} else {
    echo "❌ Job Codes Query FAILED: " . $conn->error . "<br>";
}

// 2. Check Employees Query (used in index)
echo "<h3>Testing list_employee()</h3>";
// Mimic Employee_model::list_employee
$sql_emp = "SELECT geopos_employees.*,geopos_users.banned,geopos_users.roleid,geopos_users.loc 
            FROM geopos_employees 
            LEFT JOIN geopos_users ON geopos_employees.id = geopos_users.id 
            ORDER BY geopos_users.roleid DESC";
            
$res_emp = $conn->query($sql_emp);

if($res_emp) {
    echo "✅ Employee Query Successful. Rows: " . $res_emp->num_rows . "<br>";
} else {
    echo "❌ Employee Query FAILED: " . $conn->error . "<br>";
}

echo "<h3>Conclusion</h3>";
echo "If both queries above pass, the PHP logic is likely fine.<br>";
echo "The 403 is likely happening deeper in the CI Controller initialization or Aauth check.<br>";

$conn->close();
?>
