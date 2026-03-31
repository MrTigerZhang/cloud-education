<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Services\Logic;

use App\Validators\Comment as CommentValidator;

trait CommentTrait
{

    public function checkComment($id)
    {
        $validator = new CommentValidator();

        return $validator->checkComment($id);
    }

}
