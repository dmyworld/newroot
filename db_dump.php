<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli('localhost', 'root', '', 'newroot');

echo "--- geopos_modules ---\n";
$res = $mysqli->query("SELECT * FROM geopos_modules");
while($row = $res->fetch_assoc()) {
    print_r($row);
}

echo "\n--- geopos_roles ---\n";
$res = $mysqli->query("SELECT * FROM geopos_roles");
while($row = $res->fetch_assoc()) {
    print_r($row);
}
