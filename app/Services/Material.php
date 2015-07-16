<?php

namespace App\Services;

use App\Repositories\MaterialRepository;
use Overtrue\Wechat\Media;

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

    /**
     * accountService.
     *
     * @var App\Services\AccountService
     */
    private $account;

    /**
     * $media description.
     *
     * @var Overtrue\Wechat\Media
     */
    private $media;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;

        $this->account = account()->getCurrent();

        $this->media = new Media($this->account->app_id, $this->account->app_secret);
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
        return $this->materialRepository->storeRemoteArticle($this->account->id, $articles);
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
        return $this->materialRepository->isExists($this->account->id, $materialId);
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

    /**
     * 上传素材到远程.
     *
     * @param App\Model\Material $material 素材模型
     */
    public function updateToRemote($material)
    {
        $function = camel_case('upload_remote_'.$material->type);

        return $function($material);
    }

    /**
     * 上传视频到远程.
     *
     * @param Material $video 视频素材
     *
     * @return string 微信素材id
     */
    private function uploadRemoteVideo($video)
    {
        $filePath = $this->mediaUrlToPath($video->source_url);

        return $this->media->forever()->video($filePath, $video->title, $video->description);
    }

    /**
     * 上传声音到远程.
     *
     * @param Material $voice 声音素材
     *
     * @return string 微信素材id
     */
    private function uploadRemoteVoice($voice)
    {
        $filePath = $this->mediaUrlToPath($voice->source_url);

        return $this->media->forever()->voice($filePath);
    }

    /**
     * 上传图片到远程.
     *
     * @param Material $image 图片素材
     *
     * @return string 微信素材id
     */
    private function uploadRemoteImage($image)
    {
        $filePath = $this->mediaUrlToPath($image->source_url);

        return $this->media->forever()->image($filePath);
    }

    /**
     * 上传图文素材到远程.
     *
     * @param array $articles 图文素材
     *
     * @return string
     */
    public function uploadRemoteArticles($articles)
    {
        return $this->media->news($articles);
    }

    /**
     * 素材路径转Url.
     *
     * @param string $path 路径
     *
     * @return string 地址
     */
    public function mediaPathToUrl($path)
    {
        return '/demo';
    }

    /**
     * 素材Url转路径.
     *
     * @param string $url 地址
     *
     * @return string 路径
     */
    public function mediaUrlToPath($url)
    {
        return '/demo';
    }
}
