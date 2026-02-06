<?php
// Diagnostic script to check geopos_cheques table data
$config_file = 'application/config/database.php';
$log_file = 'diag_cheques.txt';

if (!file_exists($config_file)) {
    file_put_contents($log_file, "Database config not found\n");
    die();
}

include($config_file);
$db_config = $db['default'];

$output = "";

try {
    $dsn = "mysql:host=" . $db_config['hostname'] . ";dbname=" . $db_config['database'];
    $pdo = new PDO($dsn, $db_config['username'], $db_config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $output .= "### Geopos Cheques Data Sample ###\n";
    if (!$pdo->query("SHOW TABLES LIKE 'geopos_cheques'")->fetch()) {
        $output .= "Table geopos_cheques does NOT exist.\n";
    } else {
        $stmt = $pdo->query("SELECT * FROM geopos_cheques LIMIT 10");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $output .= "Table geopos_cheques is EMPTY.\n";
        } else {
            foreach ($rows as $row) {
                $output .= json_encode($row) . "\n";
            }
        }

        $output .= "\n### Distinct Status/Type Values ###\n";
        $stmt = $pdo->query("SELECT DISTINCT type, status FROM geopos_cheques");
        $distinct = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($distinct as $d) {
            $output .= "Type: {$d['type']} | Status: {$d['status']}\n";
        }
    }

} catch (PDOException $e) {
    $output .= "Error: " . $e->getMessage() . "\n";
}

file_put_contents($log_file, $output);
echo "Diagnostic complete. Check $log_file\n";
