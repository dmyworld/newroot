<?php
define('BASEPATH', 'dummy');
define('ENVIRONMENT', 'development');
require_once 'application/config/database.php';

$db_config = $db['default'];
$m = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($m->connect_error) {
    die("Connection failed: " . $m->connect_error);
}

// Check timber logs
echo "Timber Logs Columns: ";
$res = $m->query("DESCRIBE geopos_timber_logs");
while($row = $res->fetch_assoc()) {
    if ($row['Field'] == 'revid_video_url') echo "[FOUND: " . $row['Field'] . "] ";
}
echo "\n";

// Check config
echo "Config ID 13: ";
$res = $m->query("SELECT * FROM geopos_config WHERE id=13");
$row = $res->fetch_assoc();
if ($row) {
    echo "Found (fb_profile_id: " . $row['fb_profile_id'] . ", access_token: " . ($row['access_token'] ? 'Set' : 'Empty') . ")\n";
} else {
    echo "Not Found\n";
}

$m->close();
?>
