<?php
namespace App\Repositories;

use App\Models\Fan;
use App\Services\Account;
use Overtrue\Wechat\User;

/**
 * Fans Repository
 */
class FanRepository
{
	
	use BaseRepository;
	
    /**
     * Fan
     *
     * @var Fans
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
	private $_onlineUser;

    public function __construct(Account $account, Fan $fan)
    {
		$this->_account = $account;	//use Account
		$this->_accountId = $this->_account->getCurrent()->id;
        $this->model = $fan;
		
		$sdkConfig = [
			'app_id' => $this->_account->getCurrent()->app_id,
			'secret' => $this->_account->getCurrent()->app_secret
		];
		$this->_onlineUser = new User($sdkConfig);
    }

    /**
     * 获取粉丝列表
     *
     * @param int $pageSize 分页大小
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function lists($pageSize, $request)
    {
		if(!$request->sort_by){
			$request->sort_by = 'subscribed_at';
		}
        return $this->model
				->where('account_id', $this->account->getCurrent()->id)
				->where(function($query) use ($request){
					if ($request->group_id) {
						$query->where('group_id', $request->group_id);
					}
				})
				->orderBy($request->sort_by,'desc')
				->paginate($pageSize);
    }
	
	/**
	 * 获取线上粉丝列表
	 */
	public function onlineLists()
	{
		
		set_time_limit(0);
		
		/**
		 * Online User List
		 */
		$onlineData = $this->_onlineUser->lists();
		$dataToArr = json_decode($onlineData, true);
		if(isset($dataToArr['data']['openid']) && !empty($dataToArr['data']['openid'])){
			
			/**
			 * 未取消关注的，先取消关注(设置为当前时间)
			 */
			$this->model->where('account_id', $this->_accountId)->delete();
			
			/**
			 * Prepare Data
			 */
			foreach($dataToArr['data']['openid'] as $openId){
				$input['account_id'] = $this->_accountId;
				$input['openid'] = $openId;
				
				$userInfo = $this->_onlineUser->get($openId);	//获取公众号用户信息
				if($userInfo['subscribe']){
					$updateInput['nickname'] = $userInfo['nickname'];				//昵称
					$updateInput['sex'] = $userInfo['sex'];						//性别
					$updateInput['city'] = $userInfo['city'];						//城市
					$updateInput['country'] = $userInfo['country'];				//国家
					$updateInput['province'] = $userInfo['province'];				//省
					$updateInput['language'] = $userInfo['language'];				//语言
					$updateInput['avatar'] = $userInfo['headimgurl'];				//头像
					$updateInput['subscribed_at'] = $userInfo['subscribe_time'];	//关注时间
					$updateInput['unionid'] = $userInfo['unionid'];				//unionid
					$updateInput['remark'] = $userInfo['remark'];					//备注
					$updateInput['group_id'] = $userInfo['groupid'];				//组ID
					$updateInput['deleted_at'] = NULL;
				}
				
				/**
				 * Local Save
				 */
				$model = $this->model->withTrashed()->where('openid', $openId)->first();
				if($model){
					$this->model->withTrashed()->where('id', $model['id'])->update($updateInput);
				}else{
					$this->model->insert($input);
				}
				
			}
			
		}
		
		return [$dataToArr];
	}
	
	/**
	 * 修改用户备注
	 * 
	 * @param  String	$openId
     * @param  String   $remark
	 * 
	 * @return void
	 */
	public function updateRemark($openId, $remark)
	{
		$onlineData = $this->_onlineUser->remark($openId, $remark);
		if($onlineData){
			$model = $this->model->where('openid', $openId)->first();
			$this->_savePost($model, ['remark' => $remark]);
		}
	}

    /**
     * update
     *
     * @param  integer $id
     * @param  array   $input
     *
     * @return void
     */
//    public function update($id, $input)
//    {
//        $model = $this->model->find($id);
//
//        return $this->_savePost($model, $input);
//    }

    /**
     * save
     *
     * @param  Fan $fan fan
     * @param  Request $input   输入
     *
     * @return void
     */
    private function _savePost($fan, $input)
    {
        $fan->fill($input);

        return $fan->save();
    }
	
}

