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
     * 保存远程的图文消息 [菜单处使用,此处的素材无法被提取] 
     *
     * @param  array $articles 图文消息
     *
     * @return array
     */
    public function saveRemoteArticle($articles)
    {
        return $this->articleRepository->storeRemoteArticle($articles);
    }
}