$file = "application/libraries/Aauth.php"
$lines = Get-Content $file

# Process lines 1347 to 1685 (0-indexed: 1346 to 1684)
# Adjusting based on file view: line 1348 is index 1347.
for ($i = 1347; $i -lt 1685; $i++) {
    $line = $lines[$i]
    # Remove leading specific pattern for commented out code
    # Matches: named group of spaces, then *, then optional space
    if ($line -match "^\s*\*\s?(.*)") {
        $clean = $matches[1]
        # Avoid uncommenting lines that are actual comments if possible, but for now just strip the * prefix
        # If the result starts with 'public' or '$' or '}' or '{' or 'return' it is code.
        $lines[$i] = $clean
    }
}

$lines | Set-Content $file
Write-Host "Aauth.php has been patched."
