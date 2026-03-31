<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Services\Logic\Article;

use App\Caches\CategoryTreeList as CategoryTreeListCache;
use App\Models\Category as CategoryModel;
use App\Services\Logic\Service as LogicService;

class CategoryList extends LogicService
{

    public function handle()
    {
        $cache = new CategoryTreeListCache();

        return $cache->get(CategoryModel::TYPE_ARTICLE);
    }

}
