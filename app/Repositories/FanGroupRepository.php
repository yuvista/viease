<?php
namespace App\Repositories;
/**
 * 微信粉丝组Repository
 * 
 * 功能1： 微信线上和本地粉丝组列表
 * 功能2： 微信粉丝组管理：创建、修改、删除
 * 功能3： 微信粉丝分组设置
 *
 * @author yhsong <13810377933@163.com>
 */
use App\Models\FanGroup;
use Illuminate\Pagination\Paginator;

/**
 * Fans Repository.
 */
class FanGroupRepository
{
    use BaseRepository;

    /**
     * FanGroup Model
     *
     * @var Object
     */
    protected $model;

    /**
     * Online Group.
     */
    private $onlineGroup;

    /**
     * 实例化 FanGroup Model
	 * 
	 * @author yhsong <13810377933@163.com>
     */
    public function __construct()
    {
        $this->model = new FanGroup();
    }

    /**
     * 获取本地粉丝组列表
	 * 
	 * @author yhsong <13810377933@163.com>
	 * 
	 * @param Int $accountId AccountID
	 * @param Int $pageSize 偏移量
	 * @param String $request
     *
     * @return Array
     */
    public function lists($accountId, $pageSize, $request)
    {
		if(!$request->sort_by){
			$request->sort_by = 'group_id';
		}
        return $this->model
				->where('account_id', $accountId)
				->orderBy($request->sort_by, 'asc')
				->paginate($pageSize);
    }

    /**
     * 获取线上粉丝组列表,并存入数据库
     */
    public function onlineLists()
    {
        $result = false;

        /*
         * Online Group List
         */
        $onlineData = $this->onlineGroup->lists();

        if ($onlineData) {
            /**
             * Prepare Data
             */
            $saveData = [];

            foreach ($onlineData as $groupKey => $groupVal) {
                $saveData[$groupKey]['group_id'] = $groupVal['id'];
                $saveData[$groupKey]['account_id'] = $this->accountId;
                $saveData[$groupKey]['title'] = $groupVal['name'];
                $saveData[$groupKey]['fan_count'] = $groupVal['count'];
                $saveData[$groupKey]['is_default'] = in_array($groupVal['name'], ['默认组', '屏蔽组', '星标组']) ? 1 : 0;
            }

            /*
                * Force Delete
             */
            $this->model->where('account_id', $this->accountId)->forceDelete();

            /*
                * Insert
             */
            $result = $this->model->insert($saveData);
        }

        return [$result];
    }

    /**
     * store
     *
     * @param Int $accountId AccountID
     * @param array $input
	 * 
	 * @return void
     */
    public function store($accountId, $input)
    {
		
		/**
		 * 准备插入的数据
		 */
		$_saveInfo['group_id'] = -1;
		$_saveInfo['account_id'] = $accountId;
		$_saveInfo['title'] = $input->title;
		$_saveInfo['fan_count'] = 0;
		$_saveInfo['is_default'] = 0;

		/**
		 * 保存
		 */
		$this->_savePost($this->model, $_saveInfo);
		
		/**
		 * 返回生成的ID
		 */
		return $this->model->id;
    }

    /**
     * update
     *
     * @param array $input Request
	 * @return void
     */
    public function update($accountId, $input)
    {
		
		$model = $this->getGroupByid($accountId, $input['id']);
		return $this->_savePost($model, $input);
		
    }

    /**
     * Delete.
     *
     * @param int   $id    粉丝组自增ID
     * @param array $input Request
     */
    public function delete($accountId, $id)
    {
		
		/**
		 * 1 查找粉丝组数据
		 */
		$model = $this->getGroupByid($accountId, $id);
		
		/**
		 * 2 验证这个组能不能删除
		 */
        if ($model && !$model->is_default) {
			/**
			 * 2.1) 本地粉丝所属组更新为"默认组"
			 */
			$fanRepository = new FanRepository;
			$fanRepository->moveFanGroupByGroupid($model->account_id, $model->group_id, 0);
			/**
			 * 2.2) 软删除这个组
			 */
			return $model->delete();
        }
		
    }
	
	/**
	 * 使用 粉丝组自增ID 查找分组
	 * 
	 * @param Int $id 粉丝组自增ID
	 * @param Int $accountId Account ID
	 * @return Object
	 */
	public function getGroupByid($accountId, $id)
	{
		return $this->model->where('account_id', $accountId)->where('id', $id)->first();
	}
	
	/**
	 * 使用 粉丝组group_id 查找分组
	 * 
	 * @param Int $accountId Account ID
	 * @param Int $groupId 粉丝组自增ID
	 * @return Object
	 */
	public function getGroupByGroupid($accountId, $groupId)
	{
		return $this->model->where('account_id', $accountId)->where('group_id', $groupId)->first();
	}
	
	/**
     * update
     *
	 * @param Int $accountId Account ID
	 * @param Int $addId 加粉丝的组自增ID
	 * @param array $groupIds 粉丝组group_id
     * @param array $count 数量
	 * @return void
     */
    public function cutFanCount($accountId, $addId, $groupIds, $count)
    {
		/**
		 * 增加
		 */
        $addFanGroup = $this->model->find($addId);
		$_saveAddInfo['fan_count'] = $addFanGroup->fan_count + $count;
		$this->_savePost($addFanGroup, $_saveAddInfo);
		
		/**
		 * 减掉
		 */
		foreach($groupIds as $groupId=>$groupCount)
		{
			$cutFanGroup = $this->getGroupByGroupid($accountId, $groupId);
			$_saveCutInfo['fan_count'] = $cutFanGroup->fan_count - $groupCount;
			$this->_savePost($cutFanGroup, $_saveCutInfo);
		}
    }
	
	/**
     * save
     *
     * @param  object $fanGroup
     * @param  array $input   Request
     *
     * @return void
     */
    private function _savePost($fanGroup, $input)
    {
        return $fanGroup->fill($input)->save();
    }

}
