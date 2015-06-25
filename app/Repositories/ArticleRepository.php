<?php

namespace app\Repositories;

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
    private $model;

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    /**
     * 获取图文消息列表
     *
     * @param  integer $accountId accountId
     * @param  integer $pageSize  分页
     *
     * @return void
     */
    public function lists($accountId,$pageSize)
    {
        return $this->model->where('account_id',$accountId)->where('parent_id',0)->orderBy('id', 'desc')->paginate($pageSize);
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
     *
     * @return string MediaId
     */
    private function storeRemoteMultiArticle($articles)
    {
        $articles = array_map(function ($article) {
            $article['type'] = Article::IS_REMOTE;
            $article['created_from'] = Article::CREATED_FROM_WECHAT;

            return $article;
        }, $articles);

        $firstData = $articles[0];

        $firstData['parent_id'] = 0;

        $firstArticle = $this->savePost($firstData);

        unset($articles[0]);

        foreach ($articles as $article) {
            $article['parent_id'] = $firstArticle->id;

            $this->savePost($article);
        }

        return $firstArticle->media_id;
    }

    /**
     * 存储远程单图文素材.
     *
     * @param array $article 单图文
     */
    private function storeRemoteSimpleArticle($article)
    {
        $article['type'] = Article::IS_REMOTE;
        $article['created_from'] = Article::CREATED_FROM_WECHAT;

        return $this->savePost($article);
    }

    private function store($input)
    {
        return $this->fillSavePost($this->model, $input);
    }

    /**
     * 保存 [针对于字段名称不统一].
     *
     * @param App\Models\Article $article 模型
     * @param array              $input   图文数据
     *
     * @return App\Models\Article
     */
    private function savePost($input)
    {
        $article = new $this->model();

        $article->account_id = account()->getCurrent()->id;

        $article->description = $input['digest'];

        $article->show_cover_pic = $input['show_cover'];

        $article->fill($input);

        $article->save();

        return $article;
    }

    /**
     * fillSavePost.
     *
     * @param App\Models\Article $article model
     * @param array              $input   数据
     */
    private function fillSavePost($article, $input)
    {
        $account->fill($input);

        return $account->save();
    }

    /**
     * update.
     *
     * @param int   $id
     * @param array $input
     */
    public function update($id, $input)
    {
        $model = $this->model->find($id);

        return $this->fillSavePost($model, $input);
    }
}
