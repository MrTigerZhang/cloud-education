<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "PHP Version: " . PHP_VERSION . "\n";
echo "Phalcon loaded: " . (extension_loaded('phalcon') ? 'YES' : 'NO') . "\n";

// Test basic app bootstrap
define('APP_PATH', __DIR__ . '/../');
try {
    require APP_PATH . 'bootstrap/autoload.php';
    $app = require APP_PATH . 'bootstrap/start.php';
    echo "App started OK\n";
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
