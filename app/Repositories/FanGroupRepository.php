<?php
namespace App\Repositories;

use App\Models\Fan;
use App\Models\FanGroup;
use App\Services\Account;
use Overtrue\Wechat\Group;

/**
 * Fans Repository
 */
class FanGroupRepository
{
	
	use BaseRepository;
	
    /**
     * FanGroup
     *
     * @var Fan Group
     */
    protected $model;
	
	/**
	 * Account
	 * @var Object
	 */
	private $_account;
	
	/**
	 * Account ID
	 * @var Int
	 */
	private $_accountId;
	
	/**
	 * Online Group
	 */
	private $_onlineGroup;
	
	/**
	 * Construct
	 * 
	 * @param \App\Services\Account $account
	 * @param \App\Models\FanGroup $fanGroup
	 */
    public function __construct(Account $account, FanGroup $fanGroup)
    {
		$this->_account = $account;	//use Account
		$this->_accountId = $this->_account->getCurrent()->id;
        $this->model = $fanGroup;
		
		$sdkConfig = [
			'app_id' => $this->_account->getCurrent()->app_id,
			'secret' => $this->_account->getCurrent()->app_secret
		];
		$this->_onlineGroup = new Group($sdkConfig);
    }

    /**
     * 获取本地粉丝组列表
     *
     * @param int $pageSize 分页大小
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function lists()
    {
        return $this->model
				->where('account_id', $this->_accountId)
				->orderBy('group_id', 'asc')
				->get();
    }
	
	/**
	 * 获取线上粉丝组列表,并存入数据库
	 * 
	 * @return void
	 */
	public function onlineLists()
	{
		
		$result = false;
		
		/**
		 * Online Group List
		 */
		$onlineData = $this->_onlineGroup->lists();
		
		if($onlineData){
			/**
			 * Prepare Data
			 */
			$saveData = [];

			foreach($onlineData as $groupKey=>$groupVal){
				$saveData[$groupKey]['group_id'] = $groupVal['id'];
				$saveData[$groupKey]['account_id'] = $this->_accountId;
				$saveData[$groupKey]['title'] = $groupVal['name'];
				$saveData[$groupKey]['fan_count'] = $groupVal['count'];
				$saveData[$groupKey]['is_default'] = in_array($groupVal['name'], ['默认组','屏蔽组','星标组']) ? 1 : 0;
			}

			/**
			 * Force Delete
			 */
			$this->model->where('account_id', $this->_accountId)->forceDelete();

			/**
			 * Insert
			 */
			$result = $this->model->insert($saveData);
		}
		
		return [$result];
	}

    /**
     * store
     *
     * @param  App\Models\FanGroup  $menu
     * @param  array            $input
     *
     * @return void
     */
    public function store($input)
    {
		/**
		 * online create group
		 */
		$onlineCreateResult = $this->_onlineGroup->create($input);
		
		if($onlineCreateResult){	//success
			$insert['group_id'] = $onlineCreateResult['id'];
			$insert['account_id'] = $this->_accountId;
			$insert['title'] = $onlineCreateResult['name'];
			$insert['fan_count'] = 0;
			$insert['is_default'] = 0;
			
			/**
			 * Local create group
			 */
			$this->_savePost($this->model, $insert);
		}
		
		return true;
		
    }

    /**
     * update
     *
     * @param  integer $id 粉丝组自增ID
     * @param  array   $input Request
     *
     * @return void
     */
    public function update($id, $input)
    {
		
		$model = $this->model->find($id);
		
		if($model){
			$onlineUpdateResult = $this->_onlineGroup->update($model->group_id, $input['title']);
			
			if($onlineUpdateResult){
				$this->_savePost($model, $input);
			}
		}
		
		return true;
		
    }
	
	/**
     * Delete
     *
     * @param  integer $id 粉丝组自增ID
     * @param  array   $input Request
     *
     * @return void
     */
    public function delete($id)
    {
		
		$model = $this->model->find($id);
		
		if($model){
			$onlineCreateResult = $this->_onlineGroup->delete($model->group_id);
			
			if($onlineCreateResult){
				//$this->destroy($id);
				//更新本地用户所属分组
				$fan = new Fan;
				$fan->where('account_id', $this->_accountId)
					->where('group_id', $model->group_id)
					->update(['group_id' => 0]);
				//同步线上分组
				$this->onlineLists();
				
			}
		}
		
		return true;
		
    }
	
	/**
	 * move user to group (支持批量)
	 * 
	 * @param Array $ids 粉丝自增ID
	 * @param Int $toGroupId 粉丝组group_id
	 * 
	 * @return void
	 */
	public function moveUsers($ids, $toGroupId)
	{
		if(!is_array($ids))
			return '粉丝ID不能为空';
		
		$model = $this->model->where('group_id', $toGroupId)->first();
		if(!$model){
			return '不存在这个粉丝组';
		}
		
		//根据粉丝ID查询
		$fan = new Fan;
		$fanData = $fan->find($ids);
		if($fanData){
			$openIds = [];	//OPEN
			foreach($fanData as $fanVal){
				$openIds[] = $fanVal['openid'];
			}
		}
		if($openIds){
			$onlineMoveResult = $this->_onlineGroup->moveUsers($openIds, $toGroupId);
			if($onlineMoveResult){
				//Local move
				$fan->whereIn('id', $ids)
					->update(['group_id' => $toGroupId]);
				//同步线上分组
				$this->onlineLists();
			}
		}
		return true;
	}
	

    /**
     * save
     *
     * @param  object $fanGroup
     * @param  array $input   Request
     *
     * @return void
     */
    private function _savePost($fanGroup, $input)
    {
        return $fanGroup->fill($input)->save();
    }
	
}