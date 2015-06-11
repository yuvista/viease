<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * 粉丝管理
 *
 * @author overtrue <i@overtrue.me>
 */
class FanController extends Controller
{
    public function getIndex()
    {
        return view('admin.fan.index');
    }

    /**
     * 获取粉丝列表
     *
     * @return Response
     */
    public function getLists(Request $request)
    {
        /**
         * 请求参数：
         *
         * sort_by: xxx
         * page: 1
         */

        $fans = [
            [
                "id"       => 1,
                "nickname" => "小妹你去哪儿?",
                "location" => "北京 海淀",
                "remark"   => "备注名称",
                "sex"      => "女",
                "group_id" => 3,
                "avatar"   => 'http://dn-weixinhost-admin-data.qbox.me/a72587197de4dc90.jpg',
                "signature" => '这是签名信息',
                "subscribed_at" => 1405290921,
                "liveness"  => 56,
                "last_online_at" => 1234556366,
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
                "subscribed_at" => 1405299921,
                "liveness"  => 5,
                "last_online_at" => 1234556466,
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
                "subscribed_at" => 1405296921,
                "liveness"  => 100,
                "last_online_at" => 1234556266,
            ],
        ];

        $fans = collect($fans)->sortByDesc($request->sort_by)->values()->all();

        return response()->json($fans);
    }

    /**
     * 更新粉丝备注
     *
     * @param int $id 粉丝ID
     *
     * @return Response
     */
    public function postRemark($id)
    {
        // 请求参数：remark:新的备注名
    }

    /**
     * 移动单个或者多个粉丝到指定分组
     *
     * @param int $groupId 分组ID
     *
     * @return Response
     */
    public function postSetGroup($groupId)
    {
        /**
         * 请求参数：
         * fans_id: [1,2,3,4] 或者 fans_id: 1,
         * 要求支持单个或者多个
         */
    }
}
