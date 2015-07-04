<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Material\ArticleRequest;
use App\Http\Requests\Material\ImageRequest;
use App\Http\Requests\Material\VoiceRequest;
use App\Http\Requests\Material\VideoRequest;
use App\Repositories\MaterialRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
    private $pageSize = 10;

    /**
     * materialRepository.
     *
     * @var app\Repositories\MaterialRepository
     */
    private $materialRepository;

    /**
     * accountId
     *
     * @var integer
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
        $pageSize = $request->get('page', $this->pageSize);

        return $this->materialRepository->getList($this->accountId, $request->get('type'), $pageSize);
    }

    /**
     * 统计素材数量
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
     * 创建新文章
     *
     * @param  string $value value
     *
     * @return void
     */
    public function getNewArticle($value = '')
    {
        return  admin_view('material.new-article');
    }

    /**
     * 创建新图文
     *
     * @param  ArticleRequest $request request
     *
     * @return void
     */
    public function postNewArticle(ArticleRequest $request)
    {
        
    }
}
