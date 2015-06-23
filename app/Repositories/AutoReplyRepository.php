<?php
namespace App\Repositories;

use App\Models\AutoReply;

/**
 * Account Repository
 */
class AutoReplyRepository
{
    use BaseRepository;

    /**
     * Account Model
     *
     * @var Account
     */
    protected $model;

    public function __construct(AutoReply $autoReply)
    {
        $this->model = $autoReply;
    }

    /**
     * 取得自动回复列表
     *
     * @param App\Models\Account $account account
     *
     * @return void
     */
    public function getIndex($account)
    {
        return $this->model->where('account_id', $account->id)->first();
    }
}
