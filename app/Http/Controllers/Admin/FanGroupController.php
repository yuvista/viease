<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\Account\CreateRequest;
use App\Http\Requests\Account\UpdateRequest;
use App\Repositories\FanGroupRepository;

class FanGroupController extends Controller
{
    
    /**
     * AccountRepository
     *
     * @var AccountRepository
     */
    private $_fanGroup;
    
    /**
     * constructer
     *
     * @param AccountRepository $account
     */
    public function __construct(FanGroupRepository $_fanGroup)
    {
        $this->_fanGroup = $_fanGroup;
    }
    
    /**
     * 获取分组列表
     *
     * @return Response
     */
    public function getLists()
    {
        /*
            * 请求参数：
            *
            * sort_by: xxx
            * page: 1
            */
                        //        $groups = $this->_fanGroup->lists();
                                    //      return new LengthAwarePaginator($groups, 30, 5);
//return $this->_fanGroup->onlineLists();	//获取线上列表

//return $this->_fanGroup->store('test');	//创建

//return $this->_fanGroup->update(74, ['title'=>'test113']);	//修改

        return $this->_fanGroup->delete(102);   //删除

//return $this->_fanGroup->moveUsers([2192], 113);	//粉丝分组
    }

    /**
     * 创建分组
     *
     * @return Reponse
     */
    public function postCreate(CreateRequest $request)
    {
        $rules = ['title' => 'required|min:1'];

        $this->validate($request, $rules);

        //TODO
        $this->_fanGroup->store($request);

        return [
        'id' => mt_rand(10, 999),
        'title' => $request->title,
        'fan_count' => 0
               ];
    }

    /**
     * 更改分组信息
     *
     * @param int $id 分组ID
     *
     * @return Response
     */
    public function postUpdate(UpdateRequest $request, $id)
    {
        /*
            * name: $name
         */
        
        //TODO
        $this->_fanGroup->update($id, $request);
    }
    
    /**
     * 删除分组
     *
     * @param  int $id 分组ID
     * @return Response
     */
    public function postDelete($id)
    {
        $this->_fanGroup->delete($id);
    }
}
