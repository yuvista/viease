<?php

namespace App\Repositories;

use App\Models\Fan;
use Illuminate\Pagination\Paginator;

/**
 * Fans Repository.
 */
class FanRepository
{
    use BaseRepository;

    /**
     * Fan.
     *
     * @var Fans
     */
    protected $model;

    /**
     * Online Group.
     */
    private $onlineUser;

    public function __construct()
    {
        $this->model = new Fan();
    }

    /**
     * 获取粉丝列表
     *
     * @param int $pageSize 分页大小
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function lists($accountId, $pageSize, $request)
    {
        if (!$request->sort_by) {
            $request->sort_by = 'subscribed_at';
        }

        return $this->model
				->where('account_id', $accountId)
				->where(function ($query) use ($request) {
					if ($request->group_id) {
						$query->where('group_id', $request->group_id);
					}
				})
				->orderBy($request->sort_by, 'desc')
				->paginate($pageSize);
    }

    /**
     * 获取线上粉丝列表
     */
    public function onlineLists()
    {
        set_time_limit(0);

        /*
            * Online User List
         */
        $onlineData = $this->onlineUser->lists();
        $dataToArr = json_decode($onlineData, true);
        if (isset($dataToArr['data']['openid']) && !empty($dataToArr['data']['openid'])) {
            /*
                * 未取消关注的，先取消关注(设置为当前时间)
             */
            $this->model->where('account_id', $this->accountId)->delete();

            /*
                * Prepare Data
             */
            foreach ($dataToArr['data']['openid'] as $openId) {
                $input['account_id'] = $this->accountId;
                $input['openid'] = $openId;

                $userInfo = $this->onlineUser->get($openId);   //获取公众号用户信息
                if ($userInfo['subscribe']) {
                    $updateInput['nickname'] = $userInfo['nickname'];               //昵称
                    $updateInput['sex'] = $userInfo['sex'];                         //性别
                    $updateInput['city'] = $userInfo['city'];                       //城市
                    $updateInput['country'] = $userInfo['country'];                 //国家
                    $updateInput['province'] = $userInfo['province'];               //省
                    $updateInput['language'] = $userInfo['language'];               //语言
                    $updateInput['avatar'] = $userInfo['headimgurl'];               //头像
                    $updateInput['subscribed_at'] = $userInfo['subscribe_time'];    //关注时间
                    $updateInput['unionid'] = $userInfo['unionid'];                 //unionid
                    $updateInput['remark'] = $userInfo['remark'];                   //备注
                    $updateInput['group_id'] = $userInfo['groupid'];                //组ID
                    $updateInput['deleted_at'] = null;
                }

                /*
                    * Local Save
                 */
                $model = $this->model->withTrashed()->where('openid', $openId)->first();
                if ($model) {
                    $this->model->withTrashed()->where('id', $model['id'])->update($updateInput);
                } else {
                    $this->model->insert($input);
                }
            }
        }

        return [$dataToArr];
    }

    /**
     * 修改粉丝信息
     *
     */
    public function updateRemark($request)
    {
        $model = $this->model->find($request['id']);
        return $this->_savePost($model, ['remark' => $request['remark']]);
    }
	
	/**
     * 通过粉丝ID 更改粉丝所属组(支持批量)
     *
     * @param Array $ids       粉丝自增ID
     * @param Int   $toGroupId 粉丝组group_id
     */
    public function moveFanGroupByFansid($ids, $toGroupId)
    {
		foreach ($ids as $id)
		{
			$model = $this->model->find($id);
			$this->_savePost($model, ['group_id' => $toGroupId]);
		}
		return true;
    }
	
	/**
	 * 通过粉丝ID 获取粉丝组group_id和粉丝人数[支持批量]
	 * 
	 * @param Array $ids       粉丝自增ID
	 * @return void
	 */
	public function getFanGroupByfanIds($ids)
	{
		
		$groupIds = [];
		$return = [];
		//根据粉丝ID查询group_id
        $fans = $this->model->find($ids);
        if ($fans)
		{
            foreach ($fans as $fan)
			{
                $groupIds[$fan['id']] = $fan['group_id'] ? $fan['group_id'] : 0;
            }
			
			foreach($groupIds as $groupId)
			{
				$return[$groupId] = isset($return[$groupId]) ? ($return[$groupId]+1) : 1;
			}
        }
		return $return;
		
	}
	
	/**
     * 通过粉丝组ID 更改粉丝所属组(支持批量)
     *
     * @param Array $ids       粉丝自增ID
     * @param Int   $toGroupId 粉丝组group_id
     */
    public function moveFanGroupByGroupid($accountId, $fromGroupId, $toGroupId)
    {

        //根据粉丝ID查询
        return $this->model->where('account_id', $accountId)
					->where('group_id', $fromGroupId)
					->update(['group_id' => $toGroupId]);
		
    }
	
	/**
     * save
     *
     * @param  object $fan
     * @param  array $input   Request
     *
     * @return void
     */
    private function _savePost($fan, $input)
    {
        return $fan->fill($input)->save();
    }

}
