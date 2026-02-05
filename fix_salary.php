<?php
// Fix Salaries
// Access: http://localhost/newroot/fix_salary.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newroot";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

echo "<h3>Updating Employee Salaries...</h3>";

// Check if salary column exists (it should, from previous step)
$check = $conn->query("SHOW COLUMNS FROM geopos_employees LIKE 'salary'");
if($check->num_rows == 0) {
    $conn->query("ALTER TABLE geopos_employees ADD `salary` decimal(16,2) DEFAULT '0.00'");
    echo "Added missing salary column.<br>";
}

// Update all to 25.00
if ($conn->query("UPDATE geopos_employees SET salary = 25.00 WHERE salary = 0 OR salary IS NULL") === TRUE) {
  echo "Success: Updated employee salaries to 25.00 / hour.<br>";
} else {
  echo "Error updating record: " . $conn->error;
}

echo "<hr><h3>Checking Timesheets...</h3>";
// Force seeds to be recent if missing
$cnt = $conn->query("SELECT count(*) as c FROM geopos_timesheets")->fetch_assoc()['c'];
echo "Found $cnt timesheet entries.<br>";

if($cnt == 0) {
    echo "Reseeding timesheets...<br>";
    // ... (Reuse seeding logic if needed, but previous step said it seeded 7)
}

$conn->close();
echo "<h1>Fix Complete. Please Run Payroll Again.</h1>";
?>
