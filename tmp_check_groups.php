<?php
$mysqli = new mysqli("localhost", "root", "", "newroot");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
$res = $mysqli->query("SELECT * FROM geopos_aauth_groups");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
$mysqli->close();
?>
