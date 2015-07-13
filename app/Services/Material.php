<?php

namespace App\Services;

use App\Repositories\MaterialRepository;
use Overtrue\Wechat\Media as MediaService;

/**
 * 素材服务.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Material
{
    /**
     * 拉取素材默认起始位置
     */
    const MATERIAL_DEFAULT_OFFSET = 0;

    /**
     * 拉取素材的最大数量
     */
    const MATERIAL_MAX_COUNT = 20;

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
     * media.
     *
     * @var Overtrue\Wechat\Media
     */
    private $mediaService;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;

        $this->account = account()->getCurrent();

        $this->mediaService = new MediaService([
            'app_id' => $this->account->app_id,
            'secret' => $this->account->app_secret,
        ]);
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

    /**
     * 同步远程素材到本地
     *
     * @param string $type 素材类型
     *
     * @return Response
     */
    public function syncRemoteMaterial($type)
    {
        $countNumber = $this->getRemoteMaterialCount($type);

        for($offset = self::MATERIAL_DEFAULT_OFFSET; $offset < $countNumber; $offset += self::MATERIAL_MAX_COUNT){

            $lists = $this->getRemoteMaterialLists($type, $offset, self::MATERIAL_MAX_COUNT);

            $this->localizeRemoteMaterialLists($lists, $type);
        }
    }

    /**
     * 远程素材存储本地
     *
     * @param  array $lists 素材列表
     * @param  string $type 
     *
     * @return Response
     */
    private function localizeRemoteMaterialLists($lists, $type)
    {
        return array_map(function($list) use ($type){
            $callFunc = 'storeRemote'.ucfirst($type);
            return $this->$callFunc($list);
        },$lists);
    }

    /**
     * 存储远程图片素材
     *
     * @param  array $image 素材信息
     *
     * @return Response
     */
    private function storeRemoteImage($image)
    {
        $imageUrl = $this->downloadMaterial($image);
    }

    /**
     * 存储远程声音素材
     *
     * @param  array $voice 声音素材
     *
     * @return Response
     */
    private function storeRemoteVoice($voice)
    {
        var_dump($voice);
    }

    /**
     * 存储远程视频素材
     *
     * @param  array $video 素材信息
     *
     * @return Response
     */
    private function storeRemoteVideo($video)
    {
        var_dump($video);
    }

    /**
     * 下载素材到本地
     *
     * @param  string $media 素材
     *
     * @return string 文件url
     */
    private function downloadMaterial($media)
    {
        var_dump($media['media_id']);die();
        $this->mediaService->forever()->download($media['media_id'], public_path('attachments/').rand().'.jpeg');
    }

    /**
     * 获取远程图片列表.
     *
     * @param  integer $offset 起始位置
     * @param  integer $count  获取数量
     *
     * @return array 列表
     */
    private function getRemoteMaterialLists($type, $offset, $count)
    {
        return $this->mediaService->lists($type, $offset, $count)['item'];
    }

    /**
     * 取得远程素材的数量
     *
     * @param  string $type 素材类型
     *
     * @return integer
     */
    private function getRemoteMaterialCount($type)
    {
        return $this->mediaService->stats($type);
    }
}
