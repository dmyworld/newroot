<?php
define('ENVIRONMENT', 'development');
define('BASEPATH', 'c:/Users/user/Documents/GitHub/www/newroot/system/');
define('APPPATH', 'c:/Users/user/Documents/GitHub/www/newroot/application/');

require_once(APPPATH . 'config/database.php');
$db_config = $db['default'];

$conn = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Connection failed\n");
}

echo "Simulating record_platform_revenue logic:\n";
// The logic from model:
// $this->db->where('holder', 'Platform Revenue');
// $acc = $this->db->get('geopos_accounts')->row();

$res = $conn->query("SELECT * FROM geopos_accounts WHERE holder = 'Platform Revenue' LIMIT 1");
$acc = $res->fetch_object();

if ($acc === null) {
    echo "Account is NULL (expected since it doesn't exist).\n";
    try {
        echo "Attempting to access \$acc->id...\n";
        $acid = $acc->id; 
        echo "Successfully accessed ID: " . $acid . "\n";
    } catch (Error $e) {
        echo "Caught Error: " . $e->getMessage() . "\n";
    } catch (Exception $e) {
        echo "Caught Exception: " . $e->getMessage() . "\n";
    }
    
    // PHP < 8 might just give a Notice/Warning if not using catchable errors, 
    // but CodeIgniter's error handler will turn notices into exceptions/errors.
}

$conn->close();
?>
