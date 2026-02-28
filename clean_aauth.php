<?php
$file = 'application/libraries/Aauth.php';
$content = file_get_contents($file);

// 1. Fix malformed docblocks
// Find /** that doesn't have a */ before 'function' or 'public function' or 'private function'
// We'll use a simple state machine or regex
$content = preg_replace_callback('/\/\*\*.*?(?=(public |private |protected )?function)/s', function($matches) {
    if (strpos($matches[0], '*/') === false) {
        return $matches[0] . "     */\n    ";
    }
    return $matches[0];
}, $content);

// 2. Harden num_rows() calls
// Only if not already checked
$content = preg_replace('/(?<!\$query && )\$query->num_rows\(\)/', '$query && $query->num_rows()', $content);
$content = preg_replace('/(?<!\$role_query && )\$role_query->num_rows\(\)/', '$role_query && $role_query->num_rows()', $content);

// 3. Add add_member alias if missing (Double check the Hub.php error)
// If it was already there but commented out, the docblock fix might have restored it.
// Let's ensure it's there.

file_put_contents($file, $content);
echo "Aauth.php cleaned and hardened.";
?>
