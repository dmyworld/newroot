<?php
define('BASEPATH', 'test');
define('ENVIRONMENT', 'development');
include('application/config/database.php');
$config = $db['default'];

$mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "<h2>Migration Started</h2>";

// 1. Create geopos_roles
$sql = "CREATE TABLE IF NOT EXISTS geopos_roles (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    all_access TINYINT(1) DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if ($mysqli->query($sql) === TRUE) {
    echo "Table 'geopos_roles' created/exists.<br>";
} else {
    echo "Error creating table: " . $mysqli->error . "<br>";
}

// 2. Create geopos_role_permissions
$sql = "CREATE TABLE IF NOT EXISTS geopos_role_permissions (
    id INT(11) NOT NULL AUTO_INCREMENT,
    role_id INT(11) NOT NULL,
    module_id INT(11) NOT NULL,
    can_view TINYINT(1) DEFAULT 0,
    can_add TINYINT(1) DEFAULT 0,
    can_edit TINYINT(1) DEFAULT 0,
    can_delete TINYINT(1) DEFAULT 0,
    PRIMARY KEY (id),
    KEY role_id (role_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

if ($mysqli->query($sql) === TRUE) {
    echo "Table 'geopos_role_permissions' created/exists.<br>";
} else {
    echo "Error creating table: " . $mysqli->error . "<br>";
}

// 3. Insert Default Roles
$roles = [
    1 => 'Admin',
    2 => 'Employee',
    3 => 'Sales',
    4 => 'Stock Manager',
    5 => 'Business Owner',
    6 => 'Project Manager'
];

foreach ($roles as $id => $name) {
    $all_access = ($id == 5) ? 1 : 0; // Give Business Owner all access
    $sql = "INSERT INTO geopos_roles (id, name, all_access) VALUES ($id, '$name', $all_access) 
            ON DUPLICATE KEY UPDATE name='$name', all_access=$all_access";
    $mysqli->query($sql);
}
echo "Roles inserted/updated.<br>";

echo "<h3>Migration Complete.</h3>";
echo "<p>Please return to the application and refresh the page.</p>";

$mysqli->close();
?>
