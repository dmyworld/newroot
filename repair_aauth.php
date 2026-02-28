<?php
$file = 'application/libraries/Aauth.php';
$content = file_get_contents($file);

// 1. Revert ALL changes made to /** ... blocks and redo them correctly.
// First, find all /** blocks that were botched.
// A botched block is one where */ was inserted but NOT before a real function.

// Actually, let's just use a better regex to find /** that needs */.
// We only want to add */ if it's missing AND the next thing is a function.

// First, strip all the botched */ entries we might have added.
// We'll search for things that look like our insertion: "     */\n    "
$content = str_replace("     */\n    ", "", $content);

// Also remove the specific botched line I manually fixed (v2) if it exists
$content = preg_replace('/It also updates last activity every time function called\./', "It also updates last activity every time      \n     function called.", $content);


// Now redo it correctly.
// Use a negative lookahead to ensure we don't match 'function' INSIDE the docblock.
// A real function definition usually starts with '(public|private|protected|function) name('
$content = preg_replace_callback('/\/\*\*.*?(?=(public |private |protected |function )([a-zA-Z0-9_]+)\()/s', function($matches) {
    if (strpos($matches[0], '*/') === false) {
        return $matches[0] . "     */\n    ";
    }
    return $matches[0];
}, $content);

file_put_contents($file, $content);
echo "Aauth repaired.";
?>
