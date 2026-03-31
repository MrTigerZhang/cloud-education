<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Services\Logic;

use App\Validators\Article as ArticleValidator;

trait ArticleTrait
{

    public function checkArticle($id)
    {
        $validator = new ArticleValidator();

        return $validator->checkArticle($id);
    }

}
