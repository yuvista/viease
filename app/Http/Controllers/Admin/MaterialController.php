<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Material\ArticleRequest;
use App\Http\Requests\Material\VideoRequest;
use App\Http\Requests\Material\voiceRequest;
use App\Repositories\MaterialRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;

/**
 * 素材管理.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class MaterialController extends Controller
{
    /**
     * 分页数目.
     *
     * @var int
     */
    private $pageSize = 12;

    /**
     * materialRepository.
     *
     * @var app\Repositories\MaterialRepository
     */
    private $materialRepository;

    /**
     * accountId.
     *
     * @var int
     */
    private $accountId;

    /**
     * construct.
     */
    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;

        $this->accountId = account()->getCurrent()->id;
    }

    /**
     * 取得素材列表.
     */
    public function getIndex()
    {
        return admin_view('material.index');
    }

    /**
     * 取得素材列表.
     *
     * @param Request $request request
     */
    public function getLists(Request $request)
    {
        $pageSize = $request->get('page_size', $this->pageSize);

        return $this->materialRepository->getList($this->accountId, $request->get('type'), $pageSize);
    }

    /**
     * 统计素材数量.
     *
     * @return array
     */
    public function getSummary()
    {
        return [
            'image' => $this->materialRepository->countImage($this->accountId),
            'video' => $this->materialRepository->countVoide($this->accountId),
            'voice' => $this->materialRepository->countVoice($this->accountId),
            'article' => $this->materialRepository->countArticle($this->accountId),
        ];
    }

    /**
     * 创建新文章.
     *
     * @param string $value value
     */
    public function getNewArticle($value = '')
    {
        return  admin_view('material.new-article');
    }

    /**
     * 创建新图文.
     *
     * @param ArticleRequest $request request
     */
    public function postNewArticle(ArticleRequest $request)
    {
        return $this->materialRepository->storeArticle($request->get('article'));
    }

    /**
     * 创建声音.
     *
     * @param voiceRequest $request request
     */
    public function postVoice(voiceRequest $request)
    {
        return $this->materialRepository->storeVoice($this->accountId, $request);
    }

    /**
     * 创建视频.
     *
     * @param VideoRequest $request request
     */
    public function postVideo(VideoRequest $request)
    {
        return $this->materialRepository->storeVideo($this->accountId, $request);
    }
}
