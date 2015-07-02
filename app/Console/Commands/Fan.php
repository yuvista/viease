<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Fan as FanModel;
use App\Models\Account;
use App\Repositories\AccountRepository;
use Overtrue\Wechat\User;

class Fan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:fan {account_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '通过account_id同步线上粉丝列表';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $accountId = $this->argument('account_id');
		/**
		 * 1 获取Account
		 */
		$account = $this->getAccount($accountId);
		
		$fanModel = new FanModel;
		
		/**
		 * 2 初始化 SDK Config, 构建 SDK 对象
		 */
		$sdkConfig = [
			'app_id' => $account->app_id,
			'secret' => $account->app_secret
		];
		$userService = new User($sdkConfig);
		
		/**
		 * 3 获取公众号粉丝列表
		 */
		$fansJson = $userService->lists();
		$fans = json_decode($fansJson, true);
		
		if(!isset($fans['errmsg']))
		{
			/**
			 * 3.1 先取消关注(设置为当前时间)
			 */
			$fanModel->where('account_id', $accountId)->delete();
			
			/**
			 * 3.2 插入数据
			 */
			foreach ($fans['data']['openid'] as $openId)
			{
				$input['account_id'] = $accountId;
                $input['openid'] = $openId;
				$input['created_at'] = date('Y-m-d H:i:s');
				/**
				 * Local Save
				 */
				$model = $fanModel->withTrashed()->where('account_id', $accountId)->where('openid', $openId)->first();
				if ($model)
				{
					$updateInput['updated_at'] = date('Y-m-d H:i:s');
					$updateInput['deleted_at'] = null;
					$fanModel->withTrashed()->where('id', $model['id'])->update($updateInput);
				} else {
					$fanModel->insert($input);
				}
			}
			
			/**
			 * 3.3 获取粉丝详细信息并更新本地
			 */
			//$localFans = $fanModel->where('account_id', $accountId)->orderBy('id', 'desc')->skip(0)->take(10)->get();	//test
			$localFans = $fanModel->where('account_id', $accountId)->orderBy('id', 'desc')->get();
			foreach ($localFans as $localFan)
			{
				$this->call('sync:fan_info', array('account_id' => $account->id, 'openid' => $localFan->openid));
				sleep(5);
			}
			
		}
		
		
    }
	
	/**
	 * 获取Account
	 * 
	 * @param Int $id AccountID
	 * @return void
	 */
	private function getAccount($accountId)
	{
		$accountRepository = new AccountRepository(new Account);
		return $accountRepository->getById($accountId);
	}
	
}
