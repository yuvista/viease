<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Menu\CreateRequest;
use App\Services\Menu as MenuService;
use App\Repositories\MenuRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//test

/**
 * 菜单管理.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class MenuController extends Controller
{
    /**
     * MenuRepository.
     *
     * @var App\Repositories\MenuRepository;
     */
    private $menuRepository;

    /**
     * menu 服务
     *
     * @var App\Services\Menu
     */
    private $menuService;

    /**
     * construct.
     *
     * @param MenuRepository $menu
     */
    public function __construct(MenuRepository $menuRepository, MenuService $menuService)
    {
        $this->menuRepository = $menuRepository;

        $this->menuService = $menuService;
    }

    /**
     * 菜单.
     */
    public function getIndex()
    {
        return admin_view('menu.index', compact('menus'));
    }

    /**
     * 获取菜单列表.
     *
     * @return Response
     */
    public function getLists()
    {
        return [
            [
                'id' => 1,
                'account_id' => 2,
                'parent_id' => 0,
                'name' => '每日笑话',
                'type' => 'click',
                'key' => 'foo',
            ],
            [
                'id' => 2,
                'account_id' => 2,
                'parent_id' => 0,
                'name' => '菜单项目2',
                'type' => 'click',
                'key' => 'foo',
            ],
            [
                'id' => 3,
                'account_id' => 2,
                'parent_id' => 0,
                'name' => '菜单项目3',
                'type' => 'click',
                'key' => 'foo',
            ],
               ];
    }

    /**
     * 保存菜单.
     *
     * @param CreateRequest $request request
     */
    public function postStore(CreateRequest $request)
    {
        return [
                'id' => mt_rand(1, 99),
                'account_id' => 2,
                'parent_id' => 0,
                'name' => $request->name,
                'type' => 'click',
                'key' => 'foo',
               ];
    }
}
