<?php

namespace app\Repositories;

use App\Models\Material;

class MaterialRepository
{
    use BaseRepository;

    /**
     * model.
     *
     * @var App\Models\Material
     */
    private $model;

    public function __construct(Material $material)
    {
        $this->model = $material;
    }

    /**
     * 取得素材列表.
     *
     * @param accountId $accountId 公众号ID
     * @param string    $type      类型
     * @param int       $pageSize  分页
     *
     * @return Response
     */
    public function getList($accountId, $type, $pageSize)
    {
        return $this->model->where('type', $type)
                ->where('account_id', $accountId)
                ->where('parent_id', 0)
                ->orderBy('id', 'desc')
                ->paginate($pageSize);
    }

    /**
     * 保存菜单的远程素材.
     *
     * @param int   $accountId 公众号id
     * @param array $articles  图文
     *
     * @return string mediaId
     */
    public function storeRemoteArticle($accountId, $articles)
    {
        $isMulti = count($articles) >= 2;

        if (!$isMulti) {
            return $this->storeRemoteSimpleArticle($accountId, $articles[0]);
        } else {
            return $this->storeRemoteMultiArticle($accountId, $articles);
        }
    }

    /**
     * 统计图片.
     *
     * @param int $accountId accountId
     *
     * @return int
     */
    public function countImage($accountId)
    {
        return $this->model->where('account_id', $accountId)
                            ->where('parent_id', 0)
                            ->where('type', 'image')
                            ->count();
    }

    /**
     * 统计声音.
     *
     * @param int $accountId accountId
     *
     * @return int
     */
    public function countVoice($accountId)
    {
        return $this->model->where('account_id', $accountId)
                            ->where('parent_id', 0)
                            ->where('type', 'voice')
                            ->count();
    }

    /**
     * 统计图文数量.
     *
     * @param int $accountId accountId
     *
     * @return int
     */
    public function countArticle($accountId)
    {
        return $this->model->where('account_id', $accountId)
                            ->where('parent_id', 0)
                            ->where('type', 'article')
                            ->count();
    }

    /**
     * 统计视频数量.
     *
     * @param int $accountId accounId
     *
     * @return int
     */
    public function countVoide($accountId)
    {
        return $this->model->where('account_id', $accountId)
                            ->where('parent_id', 0)
                            ->where('type', 'voice')
                            ->count();
    }

    /**
     * 指定素材是否已经存在.
     *
     * @param int    $accountId  账号id
     * @param string $materialId mediaId
     *
     * @return bool
     */
    public function isExists($accountId, $materialId)
    {
        return $this->model->where('account_id', $accountId)->where('original_id', $materialId)->get();
    }

    /**
     * 存储声音素材.
     *
     * @param int     $accountId 公众号ID
     * @param Request $request   request
     *
     * @return string mediaId
     */
    public function storeVoice($accountId, $request)
    {
        $model = new $this->model();

        $model->type = 'voice';

        $model->source_url = $request->url;

        $model->save();

        return $model->media_id;
    }

    /**
     * 存储图片素材.
     *
     * @param int     $accountId 公众号ID
     * @param Request $request   request
     *
     * @return Response
     */
    public function storeImage($accountId, $request)
    {
        $model = new $this->model();

        $model->type = 'image';

        $model->source_url = $request->url;

        $model->save();

        return $model->media_id;
    }

    /**
     * 存储视频素材.
     *
     * @param int     $accountId 公众号id
     * @param Request $request   request
     *
     * @return Response
     */
    public function storeVideo($accountId, $request)
    {
        $model = new $this->model();

        $model->type = 'video';

        $model->title = $request->title;

        $model->description = $request->description;

        $model->source_url = $request->url;

        $model->save();

        return $model->media_id;
    }

    /**
     * 存储图文.
     *
     * @param array $articles articles
     *
     * @return
     */
    public function store($accountId, $articles)
    {
        if (count($articles) > 2) {
            return $this->storeMultiArticle($accountId, $articles);
        } else {
            return $this->storeSimpleArticle($accountId, $articles[0]);
        }
    }

    /**
     * 存储远程多图文素材.
     *
     * @param int   $accountId 公众号Id
     * @param array $articles  多图文
     * @param int   $isRemote  是否为远程图文
     *
     * @return string MediaId
     */
    private function storeMultiArticle($accountId, $articles, $isRemote = Material::IS_NOT_REMOTE)
    {
        $articles = array_map(function ($article) {

            $article['is_remote'] = $isRemote;
            $article['type'] = 'article';
            $article['created_from'] = Material::CREATED_FROM_WECHAT;

            return $article;
        }, $articles);

        $firstData = $articles[0];

        $firstData['parent_id'] = 0;

        $firstData['account_id'] = $accountId;

        $firstArticle = $this->savePost($firstData);

        unset($articles[0]);

        foreach ($articles as $article) {
            $article['parent_id'] = $firstArticle->id;

            $article['account_id'] = $accountId;

            $this->savePost($article);
        }

        return $firstArticle->media_id;
    }

    /**
     * 存储远程单图文素材.
     *
     * @param int   $accountId 公众号ID
     * @param array $article   单图文
     * @param int   $isRemote  是否为远程图文
     */
    private function storeSimpleArticle($accountId, $article, $isRemote = Material::IS_NOT_REMOTE)
    {
        $article['is_remote'] = $isRemote;
        $article['created_from'] = Material::CREATED_FROM_WECHAT;
        $article['account_id'] = $accountId;
        $article['type'] = 'article';

        return $this->savePost($article);
    }

    /**
     * 保存 [针对于字段名称不统一].
     *
     * @param App\Models\Material $material 模型
     * @param array               $input    图文数据
     *
     * @return App\Models\Material
     */
    private function savePost($input)
    {
        $article = new $this->model();

        $article->description = $input['digest'];

        $article->show_cover_pic = $input['show_cover'];

        $article->fill($input);

        $article->save();

        return $article;
    }

    /**
     * fillSavePost.
     *
     * @param App\Models\Material $material model
     * @param array               $input    数据
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
