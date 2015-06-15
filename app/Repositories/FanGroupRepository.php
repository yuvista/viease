<?php
namespace App\Repositories;

use App\Models\FanGroup;

/**
 * Fans Repository
 */
class FanGroupRepository extends BaseRepository
{
    /**
     * FanGroup
     *
     * @var Fan Group
     */
    protected $model;

    public function __construct(FanGroup $fanGroup)
    {
        $this->model = $fanGroup;
    }

    /**
     * 获取粉丝组列表
     *
     * @param int $pageSize 分页大小
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function lists()
    {
        return $this->model
				->where('account_id', $this->account_id)
				->orderBy('group_id', 'asc')
				->get();
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
        return $this->savePost($this->model,$input);
    }

    /**
     * update
     *
     * @param  integer $id
     * @param  array   $input
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
     * @param  Fan $fan fan
     * @param  Request $input   输入
     *
     * @return void
     */
    public function savePost($fan, $input)
    {
        $fan->fill($input);

        return $fan->save();
    }
	
}