<?php
// Debug: check phinx path resolution
$phinxDir = dirname(dirname(__DIR__)) . '/phinx.php'; // phinx.php is in project root
echo "phinx.php path: " . $phinxDir . "\n";
$phinxConfig = require $phinxDir;
$migrationPath = $phinxConfig['paths']['migrations'];
$resolvedPath = dirname(dirname(__DIR__)) . '/' . $migrationPath;

echo "phinx.php dir: " . dirname(dirname(__DIR__)) . "\n";
echo "Migration path from config: " . $migrationPath . "\n";
echo "Resolved migration path: " . $resolvedPath . "\n";
echo "Path exists: " . (is_dir($resolvedPath) ? 'YES' : 'NO') . "\n";

if (is_dir($resolvedPath)) {
    $files = glob($resolvedPath . '/*.php');
    echo "Migration files found: " . count($files) . "\n";
    foreach (array_slice($files, 0, 3) as $f) {
        echo "  - " . basename($f) . "\n";
    }
}
