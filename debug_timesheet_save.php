<?php
// Debug Timesheet Save
// Access: http://localhost/newroot/debug_timesheet_save.php

define('BASEPATH', 'TRUE'); // Fake
date_default_timezone_set('UTC');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newroot";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

echo "<h1>Debug Timesheet Save</h1>";

// Mock Input Data
$post_date = "2026-02-01"; // Format sent by datepicker needs to be verified. Assuming Y-m-d or d-m-Y based on config.
$post_start = "09:00:00";
$post_end = "17:00:00";
$emp_id = 1;
$job_code = 1;

echo "<h3>1. Date Parsing Test</h3>";
try {
    $d = new DateTime($post_date);
    $date_only = $d->format('Y-m-d');
    echo "✅ DateTime parsed '$post_date' bytes to '$date_only'<br>";
} catch (Exception $e) {
    echo "❌ DateTime Error: " . $e->getMessage() . "<br>";
    die();
}

$clock_in = $date_only . ' ' . $post_start;
$clock_out = $date_only . ' ' . $post_end;

echo "Clock In: $clock_in<br>";
echo "Clock Out: $clock_out<br>";

// 2. Insert Test
echo "<h3>2. Database Insert Test</h3>";

$sql = "INSERT INTO geopos_timesheets (employee_id, job_code_id, clock_in, clock_out, total_hours, status) 
        VALUES ('$emp_id', '$job_code', '$clock_in', '$clock_out', '8.00', 'Pending')";

if ($conn->query($sql) === TRUE) {
    $new_id = $conn->insert_id;
    echo "✅ New record created successfully. ID: $new_id<br>";
    
    // Verify it exists
    $ver = $conn->query("SELECT * FROM geopos_timesheets WHERE id = $new_id")->fetch_assoc();
    echo "<pre>"; print_r($ver); echo "</pre>";
    
    // Cleanup
    //$conn->query("DELETE FROM geopos_timesheets WHERE id = $new_id");
    //echo "Record deleted (cleanup).<br>";
} else {
    echo "❌ Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
