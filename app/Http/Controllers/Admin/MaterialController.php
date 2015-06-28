<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * 素材管理.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class MaterialController extends Controller
{
    /**
     * 取得素材列表.
     */
    public function getIndex()
    {
        return admin_view('material.index');
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
        $arr =  [
            [
                'id' => 4,
                'url' => 'http://expo.getbootstrap.com/thumbs/lyft-thumb.jpg',
                "media_id" => '23456789asqwertrytuyi',
            ],
            [
                'id' => 5,
                'url' => 'http://expo.getbootstrap.com/thumbs/vogue-thumb.jpg',
                "media_id" => 'qwe1234565',
            ],
            [
                'id' => 6,
                'url' => 'http://expo.getbootstrap.com/thumbs/lyft-thumb.jpg',
                "media_id" => 'wew212345tsfdg',
            ],
            [
                'id' => 7,
                'url' => 'http://expo.getbootstrap.com/thumbs/riot-thumb.jpg',
                "media_id" => '89okajhsbf,a.ssss',
            ],
            [
                'id' => 8,
                'url' => 'http://expo.getbootstrap.com/thumbs/lyft-thumb.jpg',
                "media_id" => '23456789asqwertrytuyi',
            ],
            [
                'id' => 9,
                'url' => 'http://expo.getbootstrap.com/thumbs/newsweek-thumb.jpg',
                "media_id" => '8jml;slslssl',
            ],
        ];

        return new \Illuminate\Pagination\LengthAwarePaginator(array_chunk($arr, 2)[\Input::get('page', 1) - 1], 3, 2);
    }
}
