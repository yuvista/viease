<?php

namespace App\Services;

use App\Repositories\MaterialRepository;

/**
 * 素材服务.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Material
{
    /**
     * materialRepository.
     *
     * @var App\Repositories\MaterialRepository
     */
    private $materialRepository;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    /**
     * 保存远程的临时图文消息 [菜单处使用,此处的素材无法被提取].
     *
     * @param array $articles 图文消息
     *
     * @return array
     */
    public function saveRemoteArticle($articles)
    {
        return $this->materialRepository->storeRemoteArticle($articles);
    }

    /**
     * 临时素材本地化.
     *
     * @param string $materialId 素材id
     *
     * @return string 生成的自己的MediaId
     */
    public function localizeInterimMaterialId($materialId)
    {
        $remoteMaterial = $this->getInterimRemoteMaterial($materialId);
    }

    /**
     * 获取远程临时素材的信息.
     *
     * @param string $materialId 素材id
     *
     * @return array 素材信息
     */
    public function getInterimRemoteMaterial($materialId)
    {
        $appId = account()->getCurrent()->app_id;

        $appSecret = account()->getCurrent()->app_secret;
    }

    /**
     * 检测素材是否存在.
     *
     * @param string $materialId 素材id
     *
     * @return bool
     */
    public function isExists($materialId)
    {
        $accountId = account()->getCurrent()->id;

        return $this->materialRepository->isExists($accountId, $materialId);
    }

    /**
     * 生成一个素材mediaId.
     *
     * @return string mediaId
     */
    public function buildMaterialMediaId()
    {
        return 'MEDIA_'.strtoupper(uniqid());
    }
}
