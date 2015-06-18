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
     * AccountRepository
     *
     * @var AccountRepository
     */
    private $_fan;
	
	/**
	 * 获取几条数据
	 * @var type
	 */
	private $_pageSize = 30;
	
	/**
     * constructer
     *
     * @param AccountRepository $account
     */
    public function __construct(FanRepository $fan)
    {
        $this->_fan = $fan;
    }
	
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
    public function getLists(Request $request)
    {
        /**
         * 请求参数：
         *
         * page: 1
         * sort_by: xxx
         */
//		return $this->_fan->onlineLists();	//获取线上列表
//		$fans = $this->_fan->lists($this->_pageSize, $request);
//		
//        return response()->json($fans);
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
