<?php
define('BASEPATH', 'dummy');
define('ENVIRONMENT', 'development');
include 'application/config/database.php';
$db_config = $db['default'];

$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "--- GEOPOS MODULES ---\n";
$result = $mysqli->query("SELECT id, title FROM geopos_modules ORDER BY id ASC");
while ($row = $result->fetch_assoc()) {
    echo "ID: {$row['id']} | Title: {$row['title']}\n";
}

echo "\n--- RBAC MODULES ---\n";
$result = $mysqli->query("SELECT id, title FROM rbac_modules ORDER BY id ASC");
while ($row = $result->fetch_assoc()) {
    echo "ID: {$row['id']} | Title: {$row['title']}\n";
}

echo "\n--- RBAC PAGES ---\n";
$result = $mysqli->query("SELECT p.id, p.module_id, m.title as module_title, p.title as page_title, p.url FROM rbac_pages p JOIN rbac_modules m ON p.module_id = m.id ORDER BY m.id, p.id ASC");
while ($row = $result->fetch_assoc()) {
    echo "[{$row['module_title']}] ID: {$row['id']} | Title: {$row['page_title']} | URL: {$row['url']}\n";
}

$mysqli->close();
?>
