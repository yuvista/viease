<?php
namespace App\Repositories;

use App\Models\Fan;

/**
 * Fans Repository
 */
class FanRepository
{
    /**
     * Fan
     *
     * @var Fans
     */
    protected $model;

    public function __construct(Fan $fan)
    {
        $this->model = $fan;
    }

    /**
     * 获取粉丝列表
     *
     * @param int $pageSize 分页大小
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function lists($pageSize, $request)
    {
		if(!$request->sort_by){
			$request->sort_by = 'subscribed_at';
		}
        return $this->model
				->where('account_id', $this->account_id)
				->where(function($query) use ($request){
					if ($request->group_id) {
						$query->where('group_id', $request->group_id);
					}
				})
				->orderBy($request->sort_by,'desc')
				->paginate($pageSize);
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