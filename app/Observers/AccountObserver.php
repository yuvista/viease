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
    /**
     * 保存事件.
     *
     * @param Account $account account
     */
    public function saving(Account $account)
    {
        $account->token = account()->buildToken();

        $account->aes_key = account()->buildAesKey();

        // $account->tag = account()->buildTag();
    }

    /**
     * 创建事件.
     *
     * @param Account $account account
     */
    public function created(Account $account)
    {
    }
}
