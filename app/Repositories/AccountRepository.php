<?php 
namespace App\Repositories;

use App\Models\Account;

/**
 * Account Repository
 */
class AccountRepository extends BaseRepository
{
    protected $model;

    public function __construct(Account $account)
    {
        $this->model = $account;
    }

    public function getList()
    {
        return $this->model->orderBy('id','desc')->paginate(10);
    }

    /**
     * store
     *
     * @param  App\Models\Menu  $menu
     * @param  array            $input
     *
     * @return void
     */
    public function store($input)
    {
        $model = new $this->model;

        return $this->savePost($model,$input);
    }

    /**
     * update
     *
     * @param  integer $id    
     * @param  array   $input 
     *
     * @return void
     */
    public function update($id,$input)
    {
        $model = $this->model->find($id);

        return $this->savePost($model,$input);
    }

    /**
     * save
     *
     * @param  Account $account account
     * @param  Request $input   输入
     *
     * @return void
     */
    public function savePost($account,$input)
    {
        $account->name = $input['name'];

        $account->original_id = $input['original_id'];

        $account->app_id = $input['app_id'];

        $account->app_secret = $input['app_secret'];

        $account->wechat_account = $input['wechat_account'];

        $account->type = $input['type'];

        return $account->save();
    }
}