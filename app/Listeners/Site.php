<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Listeners;

use App\Models\User as UserModel;
use App\Traits\Client as ClientTrait;
use Phalcon\Events\Event as PhEvent;

class Site extends Listener
{

    use ClientTrait;

    public function afterView(PhEvent $event, $source, UserModel $user)
    {

    }

}