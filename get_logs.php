<?php
$log_file = 'application/logs/log-2026-02-17.php';
if (file_exists($log_file)) {
    $lines = file($log_file);
    $recent = array_slice($lines, -100);
    foreach ($recent as $line) {
        echo $line;
    }
} else {
    echo "Log file not found.";
}
?>
