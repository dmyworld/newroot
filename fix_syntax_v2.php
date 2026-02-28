<?php
$file = 'application/libraries/Aauth.php';
$content = file_get_contents($file);

// Fix the specific botched line
$content = preg_replace('/It also updates last activity every time\s+\*\/\s+function called\./', 'It also updates last activity every time function called.', $content);

file_put_contents($file, $content);
echo "Aauth syntax fixed (v2).";
?>
