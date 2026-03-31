<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Services\Search;

class ArticleSearcher extends Searcher
{

    public function __construct()
    {
        $this->xs = $this->getXS();
    }

    public function getXS()
    {
        $filename = config_path('xs.article.ini');

        return new \XS($filename);
    }

    public function getHighlightFields()
    {
        return ['title', 'summary'];
    }

}
