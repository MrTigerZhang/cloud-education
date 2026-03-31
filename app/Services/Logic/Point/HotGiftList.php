<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Services\Logic\Point;

use App\Caches\PointHotGiftList;
use App\Services\Logic\Service as LogicService;

class HotGiftList extends LogicService
{

    public function handle()
    {
        $cache = new PointHotGiftList();

        $cache->setLimit(5);

        return $cache->get() ?: [];
    }

}
