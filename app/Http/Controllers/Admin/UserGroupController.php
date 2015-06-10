<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
    }
}
