<?php
namespace App\Repositories;

use App\Models\Menu;
use Session;

/**
 * Menu Repository
 */
class MenuRepository
{
    use BaseRepository;

    /**
     * Account Model
     *
     * @var Account
     */
    protected $model;

    public function __construct(Menu $menu)
    {
        $this->model = $menu;
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

    }
}
