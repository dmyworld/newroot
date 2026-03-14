<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'dummy');
include 'application/config/database.php';
$db_config = $db['default'];
$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

function echol($msg) { echo $msg . "\n"; }

$username = 'timberpro_owner';
$pass = '123456*';
$login_with_name = false; // from aauth.php: $config_aauth['default']['login_with_name'] = false;

echol("login_with_name is set to FALSE in config (meaning it expects an EMAIL by default).");
echol("Let's check what Aauth is doing:");

$db_identifier = 'email';
$identifier = $username;

if (!filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
    echol("IDENTIFIER IS NOT A VALID EMAIL: $identifier");
    echol("Therefore Aauth will immediately return FALSE and say 'Invalid username or password!' because it expects an email, not a username like 'timberpro_owner'.");
}

echol("\nLet's verify if login_with_name is actually false:");
$config_str = file_get_contents('application/config/aauth.php');
if (preg_match("/'login_with_name'\s*=>\s*(false|true)/i", $config_str, $matches)) {
    echol("Config value: " . $matches[0]);
}
?>
