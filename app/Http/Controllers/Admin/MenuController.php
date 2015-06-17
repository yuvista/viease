<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Menu\CreateRequest;
use App\Http\Requests\Menu\UpdateRequest;
use App\Services\Menu as MenuService;
use App\Repositories\MenuRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

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
     * 菜单首页
     *
     * @return void
     */
    public function getIndex()
    {
        $remoteMenus = $this->menuService->getMenus();

        return view('admin.services.menu.index',compact('menus'));
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