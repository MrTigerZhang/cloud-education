<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Library;

class AppInfo
{

    protected $name = '易学宝云课堂';

    protected $alias = 'DATA';

    protected $link = 'https://www.swinner.fun';

    protected $version = '1.8.3';

    public function __get($name)
    {
        return $this->get($name);
    }

    public function get($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }

        return null;
    }

}
