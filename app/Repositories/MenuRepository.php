<?php

namespace App\Repositories;

use App\Models\Menu;

/**
 * Menu Repository.
 */
class MenuRepository
{
    use BaseRepository;

    /**
     * Account Model.
     *
     * @var Account
     */
    protected $model;

    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }

    /**
     * 获取账户列表.
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
     * store.
     *
     * @param App\Models\Menu $menu
     * @param array           $input
     */
    public function store($input)
    {
    }

    /**
     * update.
     *
     * @param int   $id
     * @param array $input
     */
    public function update($id, $input)
    {
    }

    /**
     * save.
     *
     * @param Account $account account
     * @param Request $input   输入
     */
    public function savePost($account, $input)
    {
    }
}
