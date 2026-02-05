<?php
// Verify Module Status
// Access: http://localhost/newroot/verify_module.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newroot";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

echo "<h1>Module Verification Status</h1>";

// Check Settings Tables
echo "<h3>1. Settings Module</h3>";
$tables = ['geopos_overtime_rules', 'geopos_deduction_types', 'geopos_job_codes', 'geopos_payroll_config'];
foreach($tables as $t) {
    if ($conn->query("SHOW TABLES LIKE '$t'")->num_rows == 1) {
        $count = $conn->query("SELECT count(*) as c FROM $t")->fetch_assoc()['c'];
        echo "✅ Table <b>$t</b> exists. Rows: $count<br>";
    } else {
        echo "❌ Table <b>$t</b> MISSING!<br>";
    }
}

// Check Timesheets
echo "<h3>2. Timesheets Module</h3>";
$t = 'geopos_timesheets';
if ($conn->query("SHOW TABLES LIKE '$t'")->num_rows == 1) {
    $count = $conn->query("SELECT count(*) as c FROM $t")->fetch_assoc()['c'];
    echo "✅ Table <b>$t</b> exists. Rows: $count<br>";
    
    // Check for recent entries
    $recent = $conn->query("SELECT * FROM $t ORDER BY id DESC LIMIT 5");
    if($recent->num_rows > 0) {
        echo "<ul>";
        while($r = $recent->fetch_assoc()) {
            echo "<li>Entry ID: {$r['id']} | Date: {$r['date']} | Hours: {$r['total_hours']}</li>";
        }
        echo "</ul>";
    }
} else {
    echo "❌ Table <b>$t</b> MISSING!<br>";
}

// Check Approvals / Payroll Runs
echo "<h3>3. Payroll Runs & Approvals</h3>";
$t = 'geopos_payroll_runs';
if ($conn->query("SHOW TABLES LIKE '$t'")->num_rows == 1) {
    $count = $conn->query("SELECT count(*) as c FROM $t")->fetch_assoc()['c'];
    echo "✅ Table <b>$t</b> exists. Rows: $count<br>";
     $recent = $conn->query("SELECT * FROM $t ORDER BY id DESC LIMIT 5");
      if($recent->num_rows > 0) {
        echo "<table border=1><tr><th>ID</th><th>Total</th><th>Status</th></tr>";
        while($r = $recent->fetch_assoc()) {
            echo "<tr><td>{$r['id']}</td><td>{$r['total_amount']}</td><td>{$r['status']}</td></tr>";
        }
        echo "</table>";
    }
} else {
    echo "❌ Table <b>$t</b> MISSING!<br>";
}

$conn->close();
?>
