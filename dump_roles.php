<?php
define('BASEPATH', 'dummy');
define('ENVIRONMENT', 'development');
require_once 'application/config/database.php';
$db_config = $db['default'];
$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);
$result = $mysqli->query('SELECT * FROM aauth_groups');
while($row = $result->fetch_assoc()) {
    echo json_encode($row) . "\n";
}
$mysqli->close();
