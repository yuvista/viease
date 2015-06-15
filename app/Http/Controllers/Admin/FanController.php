<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\FanRepository;

/**
 * 粉丝管理
 *
 * @author overtrue <i@overtrue.me>
 */
class FanController extends Controller
{
	
	/**
	 * 获取几条数据
	 * @var type
	 */
	private $_pageSize = 30;
	
	/**
	 * 当前页码
	 * @var Int
	 */
	public $currentPageNumber;
	
    public function getIndex()
    {
        return view('admin.fan.index');
    }

    /**
     * 获取粉丝列表
     *
     * @return Response
     */
    public function getLists(Request $request, FanRepository $fan)
    {
        /**
         * 请求参数：
         *
         * page: 1
         * sort_by: xxx
         */
//		[
//                "id"       => 1,
//                "nickname" => "小妹你去哪儿?",
//                "location" => "北京 海淀",
//                "remark"   => "备注名称",
//                "sex"      => "女",
//                "group_id" => 3,
//                "avatar"   => 'http://dn-weixinhost-admin-data.qbox.me/a72587197de4dc90.jpg',
//                "signature" => '这是签名信息',
//                "followd_at" => 1405290921,
//                "liveness"  => 56,
//                "last_speaking_at" => 1234556366,
//            ]
		
		$fans = $fan->lists($this->_pageSize, $request);
		
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
