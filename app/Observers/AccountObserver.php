<?php

namespace App\Observers;

use App\Models\Account;

/**
 * Account模型观察者.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class AccountObserver
{
    public function saving(Account $account)
    {
        $account->token = account()->buildToken();

        $account->aes_key = account()->buildAesKey();
    }
}
