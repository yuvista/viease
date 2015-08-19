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
        $menuList = $this->menuRepository->lists($this->account()->id);

        return $this->menuRepository->resolveMenuList($menuList);
    }

    /**
     * 保存菜单.
     *
     * @param CreateRequest $request request
     */
    public function postStore(CreateRequest $request)
    {
        $accountId = $this->account()->id;

        $this->menuRepository->destroyOldMenu($accountId);

        $menus = $this->menuService->parseMenus($accountId, $request->get('menus'));

        $this->menuRepository->storeMulti($accountId, $menus);

        //$this->menuService->saveToRemote($accountId, $menus);

        return response()->json(['status' => true]);
    }
}
