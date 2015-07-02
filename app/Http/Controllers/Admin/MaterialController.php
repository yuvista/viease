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

    public function getSummary()
    {
        return [
            'image' => 5678,
            'video' => 90,
            'voice' => 34,
            'article' => 127008,
        ];
    }

    public function getLists()
    {
        // $type：image, video, voice, article
        $arr = [
            [
                'id' => 4,
                'url' => 'http://expo.getbootstrap.com/thumbs/lyft-thumb.jpg',
                'media_id' => '23456789asqwertrytuyi',
            ],
            [
                'id' => 5,
                'url' => 'http://expo.getbootstrap.com/thumbs/vogue-thumb.jpg',
                'media_id' => 'qwe1234565',
            ],
            [
                'id' => 6,
                'url' => 'http://expo.getbootstrap.com/thumbs/lyft-thumb.jpg',
                'media_id' => 'wew212345tsfdg',
            ],
            [
                'id' => 7,
                'url' => 'http://expo.getbootstrap.com/thumbs/riot-thumb.jpg',
                'media_id' => '89okajhsbf,a.ssss',
            ],
            [
                'id' => 8,
                'url' => 'http://expo.getbootstrap.com/thumbs/lyft-thumb.jpg',
                'media_id' => '23456789asqwertrytuyi',
            ],
            [
                'id' => 9,
                'url' => 'http://expo.getbootstrap.com/thumbs/newsweek-thumb.jpg',
                'media_id' => '8jml;slslssl',
            ],
        ];

        return new \Illuminate\Pagination\LengthAwarePaginator(array_chunk($arr, 2)[\Input::get('page', 1) - 1], 3, 2);
    }
}
