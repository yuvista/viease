<?php

use Illuminate\Database\Seeder;

use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::create([
                'name' => '新注册公众号',
                'original_id' => 'gh_aaee1f6935ae',
                'app_id'    => 'wx1f5a3940d2412bfb',
                'app_secret' => 'b4020e08f0ad463c604badda5771cd78',
                'wechat_account' => 'binsgo',
                'token' => 'xxxxxxx',
                'aes_key' => 'xxxxxxxxx',
                'account_type' => 2,
                'access_token' => NULL,
            ]);
    }
}
