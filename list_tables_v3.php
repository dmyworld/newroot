<?php
$mysqli = new mysqli("localhost", "root", "", "timberpro");
if ($mysqli->connect_error) {
    die("Connect Error: " . $mysqli->connect_error);
}

$result = $mysqli->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    echo $row[0] . "\n";
}
?>
