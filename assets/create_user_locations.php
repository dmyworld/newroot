<?php
$conn = mysqli_connect('localhost', 'root', '', 'newroot');

$sql = "CREATE TABLE IF NOT EXISTS `geopos_user_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conn, $sql)) {
    echo "Table geopos_user_locations created or already exists.\n";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "\n";
}
