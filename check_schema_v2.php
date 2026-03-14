<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'c:/Users/user/Documents/GitHub/www/newroot/system/');
define('APPPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/');

require_once(APPPATH . 'config/database.php');
$config = $db['default'];

$conn = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function show_columns($conn, $table) {
    echo "\nColumns in $table:\n";
    $result = $conn->query("SHOW COLUMNS FROM $table");
    while($row = $result->fetch_assoc()) {
        echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
}

show_columns($conn, 'geopos_users');
show_columns($conn, 'aauth_groups');

$conn->close();
?>
