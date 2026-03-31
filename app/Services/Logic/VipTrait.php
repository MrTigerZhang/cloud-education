<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Services\Logic;

use App\Validators\Vip as VipValidator;

trait VipTrait
{

    public function checkVip($id)
    {
        $validator = new VipValidator();

        return $validator->checkVip($id);
    }

}
