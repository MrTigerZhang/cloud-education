<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Providers;

use Phalcon\Escaper as PhEscaper;

class Escaper extends Provider
{

    protected $serviceName = 'escaper';

    public function register()
    {
        $this->di->setShared($this->serviceName, PhEscaper::class);
    }

}
