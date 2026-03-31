<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

$config = require __DIR__ . '/config/config.php';

return [

    'version_order' => 'creation',

    'paths' => [
        'migrations' => __DIR__ . '/db/migrations',
        'seeds' => __DIR__ . '/db/seeds',
    ],

    'environments' => [

        'default_migration_table' => 'kg_migration',

        'default_environment' => 'production',

        'production' => [
            'adapter' => 'mysql',
            'host' => $config['db']['host'],
            'port' => $config['db']['port'],
            'name' => $config['db']['dbname'],
            'user' => $config['db']['username'],
            'pass' => $config['db']['password'],
            'charset' => $config['db']['charset'],
        ],
    ],

];
