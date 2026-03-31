<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Services\Logic\Course;

use App\Caches\CourseTopicList as CourseTopicListCache;
use App\Services\Logic\CourseTrait;
use App\Services\Logic\Service as LogicService;

class TopicList extends LogicService
{

    use CourseTrait;

    public function handle($id)
    {
        $course = $this->checkCourse($id);

        $cache = new CourseTopicListCache();

        $result = $cache->get($course->id);

        return $result ?: [];
    }

}
