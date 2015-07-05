<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Fan as FanModel;
use App\Models\Account;
use App\Repositories\AccountRepository;
use Overtrue\Wechat\User;

class FanInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:fan_info {account_id} {openid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '通过openid同步线上粉丝详情';

    /**
     * Create a new command instance.
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
        $openId = $this->argument('openid');
        /*
         * 1 获取Account
         */
        $account = $this->getAccount($accountId);

        $fanModel = new FanModel();
        /*
         * 2 初始化 SDK Config, 构建 SDK 对象
         */
        $sdkConfig = [
            'app_id' => $account->app_id,
            'secret' => $account->app_secret,
        ];
        $userService = new User($sdkConfig);
        $fan = $userService->get($openId);

        if (isset($fan['subscribe']) && $fan['subscribe']) {    //subscribe=1 关注了公众号
            $updateInput['nickname'] = $fan['nickname'];               //昵称
            $updateInput['sex'] = $fan['sex'] ? '男' : '女';                         //性别
            $updateInput['city'] = $fan['city'];                       //城市
            $updateInput['country'] = $fan['country'];                 //国家
            $updateInput['province'] = $fan['province'];               //省
            $updateInput['language'] = $fan['language'];               //语言
            $updateInput['avatar'] = $fan['headimgurl'];               //头像
            $updateInput['subscribed_at'] = date('Y-m-d H:i:s', $fan['subscribe_time']);    //关注时间
            $updateInput['unionid'] = $fan['unionid'];                 //unionid
            $updateInput['remark'] = $fan['remark'];                   //备注
            $updateInput['group_id'] = $fan['groupid'] ? $fan['groupid'] : 0;                //组ID
            $updateInput['deleted_at'] = null;

            /*
             * 存入本地
             */
            $fanModel->where('account_id', $accountId)->where('openid', $openId)->update($updateInput);
        }
    }

    /**
     * 获取Account.
     *
     * @param Int $id AccountID
     */
    private function getAccount($accountId)
    {
        $accountRepository = new AccountRepository(new Account());

        return $accountRepository->getById($accountId);
    }
}
