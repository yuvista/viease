<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class UserGroupController extends Controller
{
    /**
     * 获取分组列表
     *
     * @return Response
     */
    public function getLists()
    {
        /**
         * 请求参数：
         *
         * sort_by: xxx
         * page: 1
         */
        $groups = [
                 [
                    "id" => 1,
                    "title" => "分组1",
                    "user_count" => 34,
                 ],
                 [
                    "id" => 2,
                    "title" => "分组2",
                    "user_count" => 4,
                 ],
                 [
                    "id" => 3,
                    "title" => "分组3",
                    "user_count" => 3,
                 ],
                 [
                    "id" => 4,
                    "title" => "分组4",
                    "user_count" => 324,
                 ],
                 [
                    "id" => 5,
                    "title" => "分组5",
                    "user_count" => 1034,
                 ],
                 [
                    "id" => 6,
                    "title" => "分组6",
                    "user_count" => 0,
                 ],
            ];

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

        return ['id' => mt_rand(10, 999), 'title' => $request->title, 'user_count' => 0];
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
