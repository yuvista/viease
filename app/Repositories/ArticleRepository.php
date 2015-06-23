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

    // /**
    //  * 获取图文列表
    //  *
    //  * @param int $pageSize 分页大小
    //  *
    //  * @return \Illuminate\Pagination\Paginator
    //  */
    // public function lists($pageSize)
    // {
    //     return $this->model->orderBy('id','desc')->paginate($pageSize);
    // }

    // public function store($input)
    // {
    //     return $this->savePost($this->model,$input);
    // }

    // public function update($id, $input)
    // {
    //     $model = $this->model->find($id);

    //     return $this->savePost($model,$input);
    // }

    // public function savePost($model,$input)
    // {
    //     $model->fill($input);

    //     $model->save();
    // }
}
