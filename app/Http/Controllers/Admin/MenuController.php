<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Menu\CreateRequest;
use App\Services\Menu as MenuService;
use App\Repositories\MenuRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $accountId = account()->getCurrent()->id;

        return $this->menuRepository->lists($accountId);
    }

    /**
     * 同步菜单数据到本地.
     *
     * @return Response
     */
    public function getSync()
    {
        $accountId = account()->getCurrent()->id;

        $this->menuService->destroyOldMenu($accountId);

        $this->menuService->syncToLocal($accountId);
    }

    /**
     * 保存菜单.
     *
     * @param CreateRequest $request request
     */
    public function postStore(CreateRequest $request)
    {
        $accountId = account()->getCurrent()->id;

        $this->menuService->destroyOldMenu($accountId);

        $menus = $this->menuService->analyseMenus($request->get('menus'));

        return $this->menuRepository->storeMulti($accountId, $menus);
    }
}
