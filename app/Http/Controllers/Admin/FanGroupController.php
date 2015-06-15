<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\FanGroupRepository;

class FanGroupController extends Controller
{
    /**
     * 获取分组列表
     *
     * @return Response
     */
    public function getLists(FanGroupRepository $fanGroup)
    {
        /**
         * 请求参数：
         *
         * sort_by: xxx
         * page: 1
         */
        $groups = $fanGroup->lists();

        return new LengthAwarePaginator($groups, 30, 5);
    }

    /**
     * 创建分组
     *
     * @return Reponse
     */
    public function postStore(Request $request)
    {
        $rules = [
            'title' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        //TODO

        return ['id' => mt_rand(10, 999), 'title' => $request->title, 'fan_count' => 0];
    }

    /**
     * 更新分组信息
     *
     * @param int $id 分组ID
     *
     * @return Response
     */
    public function postUpdate($id)
    {
        /**
         * name: $name
         */
        //TODO
    }
}
