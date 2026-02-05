<?php
$mysqli = new mysqli("localhost", "root", "", "newroot");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT * FROM geopos_premissions";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // Fetch all columns
    $fields = $result->fetch_fields();
    $headers = [];
    foreach ($fields as $field) {
        $headers[] = $field->name;
    }
    echo implode("\t", $headers) . "\n";

    while($row = $result->fetch_assoc()) {
        echo implode("\t", $row) . "\n";
    }
} else {
    echo "0 results";
}
$mysqli->close();
?>
