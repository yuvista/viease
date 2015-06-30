<?php

namespace App\Http\Controllers\Admin;

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
     * construct.
     */
    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
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
    public function getList(Request $request)
    {
        $accountId = account()->getCurrent()->id;

        $pageSize = $request->get('page', $this->pageSize);

        return $this->materialRepository->getList($accountId, $request->get('type'), $pageSize);
    }

    /**
     * 取得素材中的图文素材.
     */
    public function getArticle()
    {
        return admin_view('material.article');
    }
}
