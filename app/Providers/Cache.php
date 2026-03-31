<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Providers;

use App\Library\Cache\Backend\Redis as RedisBackend;
use Phalcon\Cache\Frontend\Data as DataFrontend;
use Phalcon\Config;

class Cache extends Provider
{

    protected $serviceName = 'cache';

    public function register()
    {
        /**
         * @var Config $config
         */
        $config = $this->di->getShared('config');

        $this->di->setShared($this->serviceName, function () use ($config) {

            $frontend = new DataFrontend([
                'lifetime' => $config->path('cache.lifetime'),
            ]);

            return new RedisBackend($frontend, [
                'host' => $config->path('redis.host'),
                'port' => $config->path('redis.port'),
                'auth' => $config->path('redis.auth'),
                'index' => $config->path('redis.index'),
            ]);
        });
    }

}
