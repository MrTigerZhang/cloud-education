<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Providers;

class Router extends Provider
{

    protected $serviceName = 'router';

    public function register()
    {
        $this->di->setShared($this->serviceName, function () {
            return require config_path('routes.php');
        });
    }

}
