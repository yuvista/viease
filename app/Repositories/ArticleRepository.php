<?php

namespace App\Repositories;

use App\Models\Article;

/**
 * Article Repository.
 */
class ArticleRepository
{
    use BaseRepository;

    /**
     * Article Model.
     *
     * @var Article
     */
    protected $model;

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    /**
     * 保存菜单的远程素材.
     *
     * @param array $articles 图文
     */
    public function storeRemoteArticle($articles)
    {
        $isMulti = count($articles) >= 2;

        if (!$isMulti) {
            return $this->storeRemoteSimpleArticle($articles);
        } else {
            return $this->storeRemoteMultiArticle($articles);
        }
    }

    /**
     * 存储远程多图文素材.
     *
     * @param array $articles 多图文
     */
    public function storeRemoteMultiArticle($articles)
    {
        $parentId = 0;

        foreach ($articles as $article) {
        }
    }

    /**
     * 存储远程单图文素材.
     *
     * @param array $article 单图文
     */
    public function storeRemoteSimpleArticle($article)
    {
    }
}
