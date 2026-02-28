<?php
// DB Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "newroot";

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Create geopos_timber_photos table
$sql = "CREATE TABLE IF NOT EXISTS `geopos_timber_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lot_id` int(11) NOT NULL,
  `lot_type` varchar(50) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if ($mysqli->query($sql) === TRUE) {
    echo "Table geopos_timber_photos created successfully";
} else {
    echo "Error creating table: " . $mysqli->error;
}

$mysqli->close();
?>
