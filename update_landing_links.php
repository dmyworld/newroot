<?php
$file = 'c:/Users/user/Documents/GitHub/www/newroot/application/views/hub/landing.php';
$content = file_get_contents($file);

// Update all registration links to hub/register
$content = str_replace("base_url('hub/register_seller')", "base_url('hub/register')", $content);
$content = str_replace("base_url('hub/register_buyer')", "base_url('hub/register')", $content);

file_put_contents($file, $content);
echo "Landing page links updated.\n";
?>
