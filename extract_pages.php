<?php
$dir = __DIR__ . '/application/controllers';
$files = scandir($dir);
$result = [];

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        $path = $dir . '/' . $file;
        $content = file_get_contents($path);
        
        if (preg_match('/class\s+([A-Za-z0-9_]+)\s+extends/i', $content, $match)) {
            $class = $match[1];
            
            preg_match_all('/public\s+function\s+([A-Za-z0-9_]+)\s*\(/i', $content, $matches);
            $methods = [];
            if (!empty($matches[1])) {
                foreach ($matches[1] as $m) {
                    if (strpos($m, '_') !== 0 && strtolower($m) !== '__construct' && strtolower($m) !== 'get_instance') {
                        $methods[] = $m;
                    }
                }
            }
            
            if (!empty($methods)) {
                $result[$class] = $methods;
            }
        }
    }
}

file_put_contents('controller_methods.json', json_encode($result, JSON_PRETTY_PRINT));
echo "Extraction complete. Total controllers: " . count($result) . "\n";
