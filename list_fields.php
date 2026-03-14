<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'c:/Users/user/Documents/GitHub/www/newroot/system/');
define('APPPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/');

require_once(APPPATH . 'config/database.php');
$config = $db['default'];
$conn = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);

$result = $conn->query("DESCRIBE geopos_employees");
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . "\n";
}
$conn->close();
?>
