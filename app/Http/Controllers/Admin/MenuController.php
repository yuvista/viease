<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Menu\CreateRequest;
use App\Http\Requests\Menu\UpdateRequest;
use App\Services\Menu as MenuService;
use App\Repositories\MenuRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

//test
use Overtrue\Wechat\Media;

/**
 * 菜单管理
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class MenuController extends Controller
{
    /**
     * MenuRepository
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
     * construct
     *
     * @param MenuRepository $menu
     */
    public function __construct(MenuRepository $menuRepository, MenuService $menuService)
    {
        $this->menuRepository = $menuRepository;

        $this->menuService = $menuService;
    }

    /**
     * 菜单 
     *
     * @return void
     */
    public function getIndex()
    {

        //逻辑 ： 每次打开菜单都要 拉取一次菜单 解析菜单中的数据 保存为事件和素材 

        //获取远程菜单

        $menus = $this->menuService->localize($this->menuService->getMenus());

        var_dump($menus);die();

        //保存数据
        $this->menuRepository->store($this->menuService->localize($menus));

        return view('admin.menu.index', compact('menus'));
    }

    /**
     * 保存菜单
     *
     * @param  CreateRequest $request request
     *
     * @return void
     */
    public function postStore(CreateRequest $request)
    {
        var_dump($request);die();
    }
}