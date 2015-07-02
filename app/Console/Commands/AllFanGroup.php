<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Account;

class AllFanGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:all_groups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '获取全部公众号,同步粉丝组';

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
        $accountModel = new Account;
		$accounts = $accountModel->get();
		//$accounts = $accountModel->where('id', 1)->get();	//test

		foreach($accounts as $account)
		{
			$this->call('sync:group', array('account_id' => $account->id));
		}
    }
}
