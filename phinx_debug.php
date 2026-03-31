<?php
// Debug: check phinx path resolution from project root
$baseDir = dirname(__FILE__);
echo "Project root: $baseDir\n";

$phinxConfig = require $baseDir . '/phinx.php';
$migrationPath = $phinxConfig['paths']['migrations'];
$resolvedPath = $baseDir . '/' . $migrationPath;

echo "Migration path from config: " . $migrationPath . "\n";
echo "Resolved migration path: " . $resolvedPath . "\n";
echo "Path exists: " . (is_dir($resolvedPath) ? 'YES' : 'NO') . "\n";

if (is_dir($resolvedPath)) {
    $files = glob($resolvedPath . '/*.php');
    echo "Migration files found: " . count($files) . "\n";
    foreach (array_slice($files, 0, 5) as $f) {
        echo "  - " . basename($f) . "\n";
    }
}

echo "\nphinx version_order: " . $phinxConfig['version_order'] . "\n";
echo "phinx env: " . $phinxConfig['environments']['default_environment'] . "\n";
