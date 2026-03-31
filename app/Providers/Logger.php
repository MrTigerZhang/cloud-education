<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Providers;

use App\Library\Logger as AppLogger;

class Logger extends Provider
{

    protected $serviceName = 'logger';

    public function register()
    {
        $this->di->setShared($this->serviceName, function () {

            $logger = new AppLogger();

            return $logger->getInstance('common');
        });
    }

}
