<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Account;
use App\Models\FanGroup as FanGroupModel;
use App\Repositories\AccountRepository;
use Overtrue\Wechat\Group;

class FanGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:group {account_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '通过account_id同步线上粉丝组列表';

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
        /*
         * 1 获取Account
         */
        $account = $this->getAccount($accountId);
        $fanGroupModel = new FanGroupModel();
        /*
         * 2 初始化 SDK Config, 构建 SDK 对象
         */
        $sdkConfig = [
            'app_id' => $account->app_id,
            'secret' => $account->app_secret,
        ];
        $group = new Group($sdkConfig);
        $groups = $group->lists();
        if ($groups) {
            /*
             * Prepare Data
             */
            $saveData = [];

            foreach ($groups as $groupKey => $groupVal) {
                $saveData[$groupKey]['group_id'] = $groupVal['id'];
                $saveData[$groupKey]['account_id'] = $account->id;
                $saveData[$groupKey]['title'] = $groupVal['name'];
                $saveData[$groupKey]['fan_count'] = $groupVal['count'];
                $saveData[$groupKey]['is_default'] = in_array($groupVal['name'], ['默认组', '屏蔽组', '星标组']) ? 1 : 0;
            }

            /*
             * Force Delete
             */
            $fanGroupModel->where('account_id', $account->id)->forceDelete();

            /*
             * Insert
             */
            $result = $fanGroupModel->insert($saveData);
        }

        print_r($result);
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
