<?php
// Verify Approvals Table
// Access: http://localhost/newroot/verify_approvals.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newroot";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

echo "<h1>Approvals Table Verification</h1>";

$t = 'geopos_payroll_approvals';
if ($conn->query("SHOW TABLES LIKE '$t'")->num_rows == 1) {
    echo "✅ Table <b>$t</b> exists.<br>";
    $cols = $conn->query("SHOW COLUMNS FROM $t");
    echo "<ul>";
    while($c = $cols->fetch_assoc()) {
        echo "<li>{$c['Field']} ({$c['Type']})</li>";
    }
    echo "</ul>";
} else {
    echo "❌ Table <b>$t</b> MISSING!<br>";
    // Attempt create if missing (Mini-fix)
    $sql = "CREATE TABLE `geopos_payroll_approvals` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `run_id` int(11) NOT NULL,
      `approver_id` int(11) NOT NULL,
      `status` varchar(20) NOT NULL DEFAULT 'Pending',
      `comments` text,
      `approved_at` datetime NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    if($conn->query($sql) === TRUE) {
        echo "✅ Created table <b>$t</b> automatically.<br>";
    } else {
        echo "❌ Failed to create table: " . $conn->error . "<br>";
    }
}
$conn->close();
?>
