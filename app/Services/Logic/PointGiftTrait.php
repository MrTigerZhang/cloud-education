<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Services\Logic;

use App\Validators\PointGift as PointGiftValidator;

trait PointGiftTrait
{

    public function checkPointGift($id)
    {
        $validator = new PointGiftValidator();

        return $validator->checkPointGift($id);
    }

}
