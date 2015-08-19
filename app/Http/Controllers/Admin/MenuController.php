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

        return $this->menuService->resolveMenuList($menuList);
    }

    /**
     * 保存菜单.
     *
     * @param CreateRequest $request request
     */
    public function postStore(CreateRequest $request)
    {
        $this->menuService->destroyOldMenu($this->account()->id);

        $menus = $this->menuService->analyseMenu($request->get('menus'));

        $this->menuRepository->storeMulti($this->account()->id, $menus);

<<<<<<< HEAD
        $this->menuService->saveToRemote($this->account(), $menus);
=======
        $this->menuService->saveToRemote(account()->getCurrent(), $menus);

        return response()->json(['status' => true]);
>>>>>>> 55ccd1d7cd78fd772281633fac41545c1c14ac1f
    }
}
