<?php
$conn = mysqli_connect('localhost', 'root', '', 'newroot');

echo "employee_profile columns:\n";
$res = mysqli_query($conn, 'SHOW COLUMNS FROM geopos_employees');
while($row = mysqli_fetch_row($res)) { echo "- " . $row[0] . "\n"; }

echo "\nall tables:\n";
$res2 = mysqli_query($conn, 'SHOW TABLES');
while($row = mysqli_fetch_row($res2)) { echo "- " . $row[0] . "\n"; }
