<?php
namespace App\Services;

use App\Services\Account as AccountService;
use App\Repositories\ArticleRepository;
use App\Models\Article as Model;

/**
 * 图文消息服务
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Article
{
    /**
     * articleRepository 
     *
     * @var App\Repositories\ArticleRepository
     */
    private $articleRepository;

    /**
     * accountService
     *
     * @var App\Services\Account
     */
    private $accountService;

    public function __construct(ArticleRepository $articleRepository, AccountService $accountService)
    {
        $this->articleRepository = $articleRepository;

        $this->accountService = $accountService;
    }

    /**
     * 保存图文消息 [菜单处使用]
     *
     * @param  array $articles 图文消息
     *
     * @return array
     */
    public function saveArticle($articles)
    {
        //多图文
        $isMulti = count($articles) >= 2;

        if($isMulti)
        {
            $parentId = 0;

            foreach ($articles as $key => $article) {
                var_dump($article);

                // $article['type'] = Model::MULTI_YES;

                // $article['account_id'] = $this->accountService->getId();

                // $article['parent_id'] = $parentId;

                // $parentId = $this->articleRepository->store($article);
            } 
        }
    }
}