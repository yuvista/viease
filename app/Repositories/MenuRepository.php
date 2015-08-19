<?php

namespace App\Repositories;

use App\Repositories\EventRepository;
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

    protected $eventRepository;

    public function __construct(Menu $menu, EventRepository $eventRepository)
    {
        $this->model = $menu;

        $this->eventRepository = $eventRepository;
    }

    /**
     * 菜单列表.
     *
     * @return array
     */
    public function lists($accountId)
    {
        return $this->model->with('subButtons')->where('account_id', $accountId)->where('parent_id', 0)->orderBy('id', 'asc')->get();
    }

    /**
     * 取得所有菜单 不带有层级.
     *
     * @return array
     */
    public function all($accountId)
    {
        return $this->model->where('account_id', $accountId)->get()->toArray();
    }

    /**
     * 一次存储所有菜单.
     *
     * @param int   $$accountId id
     * @param array $menus      菜单
     */
    public function storeMulti($accountId, $menus)
    {
        foreach ($menus as $key => $menu) {
            $menu['sort'] = $key;
            $menu['account_id'] = $accountId;

            $parentId = $this->store($menu)->id;

            if (!empty($menu['sub_button'])) {
                foreach ($menu['sub_button'] as $subKey => $subMenu) {
                    $subMenu['parent_id'] = $parentId;

                    $subMenu['sort'] = $subKey;

                    $subMenu['account_id'] = $accountId;

                    $this->store($subMenu);
                }
            }
        }
    }

    /**
     * 处理需要返回的菜单
     *
     * @param  array $menus 菜单
     *
     * @return array
     */
    public function resolveMenuList($menus)
    {
        var_dump($menus->toArray());die();
    }

    /**
     * 删除旧菜单.
     *
     * @param int $accountId 公众号id
     */
    public function destroyOldMenu($accountId)
    {
        $menus = $this->all($accountId);

        array_map(function ($menu) {

            if ($menu['type'] == 'click') {
                $this->eventRepository->distoryByEventKey($menu['key']);
            }

        }, $menus);

        $this->distoryMenuByAccountId($accountId);
    }

    /**
     * 根据公众号Id删除菜单.
     *
     * @param int $accountId accountId
     */
    public function distoryMenuByAccountId($accountId)
    {
        return $this->model->where('account_id', $accountId)->delete();
    }

    /**
     * 保存菜单.
     *
     * @param array $input input
     */
    public function store($input)
    {
        return $this->savePost(new $this->model(), $input);
    }

    /**
     * savePost.
     *
     * @param App\Models\Menu $menu  菜单
     * @param array           $input input
     *
     * @return App\Models\Menu
     */
    public function savePost($menu, $input)
    {
        $menu->fill($input);
        $menu->save();

        return $menu;
    }
}
