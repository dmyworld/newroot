<?php
$file = 'application/libraries/Aauth.php';
$content = file_get_contents($file);

$target = "     It also updates last activity every time      */\n     function called.";
$replacement = "     It also updates last activity every time function called.";
$content = str_replace($target, $replacement, $content);

file_put_contents($file, $content);
echo "Aauth syntax fixed.";
?>
