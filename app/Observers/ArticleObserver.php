<?php

namespace App\Observers;

use App\Services\Material as MaterialService;
use App\Models\Article;

/**
 * Article模型观察者.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class ArticleObserver
{
    /**
     * 素材服务
     *
     * @var App\Services\Material
     */
    private $materialService;

    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
    }

    public function saving(Article $article)
    {
        if ($article->parent_id == 0) {
            $article->media_id = $this->materialService->buildArticleMediaId();
        }
    }
}
