<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Services\Logic;

use App\Validators\Answer as AnswerValidator;

trait AnswerTrait
{

    public function checkAnswer($id)
    {
        $validator = new AnswerValidator();

        return $validator->checkAnswer($id);
    }

}
