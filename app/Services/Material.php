<?php

namespace App\Services;

use Overtrue\Wechat\Media as MediaService;
use App\Repositories\MaterialRepository;
use App\Models\Material as MaterialModel;

/**
 * 素材服务.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Material
{
    /**
     * 拉取素材默认起始位置.
     */
    const MATERIAL_DEFAULT_OFFSET = 0;

    /**
     * 拉取素材的最大数量.
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
     * 保存图文消息.
     *
     * @param array $articles 图文消息
     *
     * @return array
     */
    public function saveArticle(
        $accountId,
        $articles,
        $originalMediaId,
        $createdFrom,
        $canEdited)
    {
        return $this->materialRepository->storeArticle(
            $accountId,
            $articles,
            $originalMediaId,
            $createdFrom,
            $canEdited
        );
    }

    /**
     * 存储一个文字回复消息.
     *
     * @param int $accountId 公众号ID
     * @param string $text  文字内容
     *
     * @return Response
     */
    public function saveText($accountId, $text)
    {
        return $this->materialRepository->storeText($accountId, $text);
    }

    /**
     * 素材转为本地素材.
     *
     * @param string $mediaId     素材id
     * @param string $mediaType   素材类型
     * @param bool   $isTemporary 是否是临时素材
     *
     * @return string 生成的自己的MediaId
     */
    public function localizeMaterialId($mediaId, $mediaType, $isTemporary = true)
    {
        var_dump($mediaId);
        die();
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
     * 同步远程素材到本地.
     *
     * @param string $type 素材类型
     *
     * @return Response
     */
    public function syncRemoteMaterial($type)
    {
        $countNumber = $this->getRemoteMaterialCount($type);

        for ($offset = self::MATERIAL_DEFAULT_OFFSET;
             $offset < $countNumber;
             $offset += self::MATERIAL_MAX_COUNT
            ) {
            $lists = $this->getRemoteMaterialLists($type, $offset, self::MATERIAL_MAX_COUNT);

            $this->localizeRemoteMaterialLists($lists, $type);
        }
    }

    /**
     * 远程素材存储本地.
     *
     * @param array  $lists 素材列表
     * @param string $type
     *
     * @return Response
     */
    private function localizeRemoteMaterialLists($lists, $type)
    {
        return array_map(function ($list) use ($type) {
            $callFunc = 'storeRemote'.ucfirst($type);

            return $this->$callFunc($list);
        }, $lists);
    }

    /**
     * 存储远程图片素材.
     *
     * @param array $image 素材信息
     *
     * @return Response
     */
    private function storeRemoteImage($image)
    {
        $mediaId = $image['media_id'];

        if ($this->getLocalMediaId($this->account->id, $mediaId)) {
            return;
        }

        $image['local_url'] = $this->downloadMaterial('image', $mediaId);

        return $this->materialRepository->storeWechatImage($this->account->id, $image);
    }

    /**
     * 存储远程声音素材.
     *
     * @param array $voice 声音素材
     *
     * @return Response
     */
    private function storeRemoteVoice($voice)
    {
        $mediaId = $voice['media_id'];

        if ($this->getLocalMediaId($this->account->id, $mediaId)) {
            return;
        }

        $voice['local_url'] = $this->downloadMaterial('voice', $mediaId);

        return $this->materialRepository->storeWechatVoice($this->account->id, $voice);
    }

    /**
     * 存储远程视频素材.
     *
     * @param array $video 素材信息
     *
     * @return Response
     */
    private function storeRemoteVideo($video)
    {
        $mediaId = $video['media_id'];

        if ($this->getLocalMediaId($this->account->id, $mediaId)) {
            return;
        }

        $videoInfo = $this->downloadMaterial('video', $mediaId);

        return $this->materialRepository->storeWechatVideo($this->account->id, $videoInfo);
    }

    /**
     * 存储远程图文素材.
     *
     * @param array $news 图文
     *
     * @return Response
     */
    private function storeRemoteNews($news)
    {
        $mediaId = $news['media_id'];

        if ($this->getLocalMediaId($this->account->id, $mediaId)) {
            return;
        }
        $news['content']['news_item'] = $this->localizeNewsCoverMaterialId($news['content']['news_item']);

        return $this->materialRepository->storeArticle($this->account->id, $news);
    }

    /**
     * 将图文消息中的素材转换为本地.
     *
     * @return array
     */
    private function localizeNewsCoverMaterialId($newsItems)
    {
        $newsItems = array_map(function ($item) {

            $item['cover_url'] = $this->mediaIdToSourceUrl($item['thumb_media_id']);

            return $item;
        }, $newsItems);

        return $newsItems;
    }

    /**
     * mediaId转换为本地Url.
     *
     * @param string $mediaId mediaId
     *
     * @return string
     */
    private function mediaIdToSourceUrl($mediaId)
    {
        return $this->materialRepository->mediaIdToSourceUrl($mediaId);
    }

    /**
     * 下载素材到本地.
     *
     * @param string $type    素材类型
     * @param string $mediaId 素材
     *
     * @return mixed
     */
    private function downloadMaterial($type, $mediaId)
    {
        $dateDir = date('Ym').'/';

        $dir = config('material.'.$type.'.storage_path').$dateDir;

        $name = md5($mediaId);

        is_dir($dir) || mkdir($dir, 0755, true);

        if ($type == 'video') {
            $videoInfo = $this->mediaService->forever()->download($mediaId);

            ob_start();

            readfile($videoInfo['down_url']);

            $contents = ob_get_contents();

            ob_end_clean();

            file_put_contents($dir.$name.'.mp4', $contents);

            return [
                'title' => $videoInfo['title'],
                'description' => $videoInfo['description'],
                'local_url' => config('material.video.prefix').'/'.$dateDir.$name.'.mp4',
                'media_id' => $mediaId,
            ];
        } else {
            $fileName = $this->mediaService->forever()->download($mediaId, $dir, $name);

            return config('material.'.$type.'.prefix').'/'.$dateDir.$fileName;
        }
    }

    /**
     * 获取远程图片列表.
     *
     * @param int $offset 起始位置
     * @param int $count  获取数量
     *
     * @return array 列表
     */
    private function getRemoteMaterialLists($type, $offset, $count)
    {
        return $this->mediaService->lists($type, $offset, $count)['item'];
    }

    /**
     * 取得远程素材的数量.
     *
     * @param string $type 素材类型
     *
     * @return int
     */
    private function getRemoteMaterialCount($type)
    {
        return $this->mediaService->stats($type);
    }

    /**
     * 获取本地存储素材id.
     *
     * @param int    $accountId 公众号id
     * @param string $mediaId   素材id
     *
     * @return NULL|string
     */
    private function getLocalMediaId($accountId, $mediaId)
    {
        return $this->materialRepository->getLocalMediaId($accountId, $mediaId);
    }

}
