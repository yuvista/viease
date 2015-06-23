<?php
namespace App\Repositories;

use App\Models\Account;
use Session;

/**
 * Account Repository
 */
class AccountRepository
{
    use BaseRepository;

    /**
     * Account Model
     *
     * @var Account
     */
    protected $model;

    public function __construct(Account $account)
    {
        $this->model = $account;
    }

    /**
     * 获取账户列表
     *
     * @param int $pageSize 分页大小
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function lists($pageSize)
    {
        return $this->model->orderBy('id', 'desc')->paginate($pageSize);
    }

    /**
     * store
     *
     * @param App\Models\Menu $menu
     * @param array           $input
     *
     * @return void
     */
    public function store($input)
    {
        return $this->savePost($this->model, $input);
    }

    /**
     * update
     *
     * @param integer $id
     * @param array   $input
     *
     * @return void
     */
    public function update($id, $input)
    {
        $model = $this->model->find($id);

        return $this->savePost($model, $input);
    }

    /**
     * save
     *
     * @param Account $account account
     * @param Request $input   输入
     *
     * @return void
     */
    public function savePost($account, $input)
    {
        $account->fill($input->all());

        return $account->save();
    }

    /**
     * 切换公众号
     *
     * @param integer $id id
     *
     * @return void
     */
    public function change($id)
    {
        Session::put('account_id', $id);
    }
}
