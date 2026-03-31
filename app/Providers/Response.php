<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Providers;

use App\Library\Http\Response as MyResponse;

class Response extends Provider
{

    protected $serviceName = 'response';

    public function register()
    {
        $this->di->setShared($this->serviceName, function () {
            return new MyResponse();
        });
    }

}
