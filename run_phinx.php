<?php
/**
 * 直接用 Phinx API 执行迁移
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

use Phinx\Config\Config;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

$phinxConfig = require __DIR__ . '/phinx.php';

$config = new Config($phinxConfig);
$application = new PhinxApplication();
$application->setAutoExit(false);

$input = new ArrayInput([
    'command' => 'migrate',
    '--configuration' => __DIR__ . '/phinx.php',
    '--environment' => 'production',
    '--no-interaction' => true,
]);

$output = new NullOutput();
$application->run($input, $output);

echo "Done.\n";
