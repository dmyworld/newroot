<?php
define('BASEPATH', 'test');
define('ENVIRONMENT', 'development');
include('application/config/database.php');
$config = $db['default'];

$mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "<h2>Roles</h2>";
$res = $mysqli->query("SELECT * FROM geopos_roles");
if ($res) {
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>All Access</th></tr>";
    while ($row = $res->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $k => $v) {
            echo "<td>$v</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Error querying roles: " . $mysqli->error;
}

echo "<h2>User: demoadmin</h2>";
$res = $mysqli->query("SELECT id, username, roleid FROM geopos_users WHERE username = 'demoadmin'");
if ($res) {
    echo "<table border='1'><tr><th>ID</th><th>Username</th><th>RoleID</th></tr>";
    while ($row = $res->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $k => $v) {
            echo "<td>$v</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

$mysqli->close();
?>
