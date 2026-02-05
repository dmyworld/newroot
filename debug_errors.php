<?php
// Enable error display for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Bootstrap CodeIgniter
define('BASEPATH', TRUE);
$_SERVER['CI_ENV'] = 'development';

// Include the bootstrap file
require_once('index.php');
?>
