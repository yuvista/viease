<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * 用户管理
 *
 * @author overtrue <i@overtrue.me>
 */
class UserController extends Controller
{
    public function getIndex()
    {
        return view('admin.user.index');
    }

    /**
     * 获取用户列表
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

        $users = [
            [
                "id"       => 1,
                "nickname" => "小妹你去哪儿?",
                "location" => "北京 海淀",
                "remark"   => "备注名称",
                "sex"      => "女",
                "group_id" => 3,
                "avatar"   => 'http://dn-weixinhost-admin-data.qbox.me/a72587197de4dc90.jpg',
                "signature" => '这是签名信息',
            ],
            [
                "id"       => 2,
                "nickname" => "超哥",
                "location" => "北京 海淀",
                "remark"   => "安小超",
                "sex"      => "男",
                "group_id" => 3,
                "avatar"   => 'http://dn-weixinhost-admin-data.qbox.me/a72587197de4dc90.jpg',
                "signature" => '这是签名信息',
            ],
            [
                "id"       => 3,
                "nickname" => "元哥",
                "location" => "北京 海淀",
                "remark"   => "友元",
                "sex"      => "男",
                "group_id" => 5,
                "avatar"   => 'http://dn-weixinhost-admin-data.qbox.me/a72587197de4dc90.jpg',
                "signature" => '这是签名信息',
            ],
        ];

        return response()->json($users);
    }

    /**
     * 更新用户备注
     *
     * @param int $id 用户ID
     *
     * @return Response
     */
    public function postRemark($id)
    {
        // 请求参数：remark:新的备注名
    }

    /**
     * 移动单个或者多个用户到指定分组
     *
     * @param int $groupId 分组ID
     *
     * @return Response
     */
    public function postSetGroup($groupId)
    {
        /**
         * 请求参数：
         * user_id: [1,2,3,4] 或者 user_id: 1,
         * 要求支持单个或者多个
         */
    }
}
