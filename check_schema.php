<?php
$mysqli = new mysqli("localhost", "root", "", "newroot");
foreach(['geopos_roles', 'geopos_users', 'geopos_role_permissions'] as $table) {
    echo "--- $table ---\n";
    $result = $mysqli->query("DESCRIBE $table");
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
}
?>
