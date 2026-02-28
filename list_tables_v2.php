<?php
$mysqli = new mysqli("localhost", "root", "", "shoppro");
if ($mysqli->connect_error) {
    $mysqli = new mysqli("localhost", "root", "", "timberpro");
}
if ($mysqli->connect_error) {
    die("Connect Error: " . $mysqli->connect_error);
}

$result = $mysqli->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    echo $row[0] . " \n";
}
?>
