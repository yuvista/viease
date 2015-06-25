<?php

namespace App\Services;

use App\Repositories\MaterialRepository;
use App\Repositories\ArticleRepository;

/**
 * 素材服务.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Material
{
    /**
     * articleRepository.
     *
     * @var App\Repositories\ArticleRepository
     */
    private $articleRepository;

    /**
     * materialRepository.
     *
     * @var App\Repositories\MaterialRepository
     */
    private $materialRepository;

    public function __construct(ArticleRepository $articleRepository, MaterialRepository $materialRepository)
    {
        $this->articleRepository = $articleRepository;

        $this->materialRepository = $materialRepository;
    }

    /**
     * 保存远程的图文消息 [菜单处使用,此处的素材无法被提取].
     *
     * @param array $articles 图文消息
     *
     * @return array
     */
    public function saveRemoteArticle($articles)
    {
        return $this->articleRepository->storeRemoteArticle($articles);
    }


    public function localizeMaterialId($materialId)
    {

    }

    /**
     * 生成一个图文mediaId.
     *
     * @return string mediaId
     */
    public function buildArticleMediaId()
    {
        return 'MEDIA_A_'.strtoupper(uniqid());
    }

    /**
     * 生成一个素材mediaId
     *
     * @return string mediaId
     */
    public function buildMaterialMediaId()
    {
        return 'MEDIA_M_'.strtoupper(uniqid());
    }
}
