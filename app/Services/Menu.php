<?php

namespace App\Services;

use Overtrue\Wechat\MenuItem as WechatMenuItem;
use App\Services\Account as AccountService;
use Overtrue\Wechat\Menu as WechatMenu;
use App\Repositories\MenuRepository;

/**
 * 菜单服务提供类
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Menu {

    /**
     * account服务
     *
     * @var App\Services\Account
     */
    private $accountService;

    /**
     * menuRepository
     *
     * @var App\Repositories\MenuRepository
     */
    private $menuRepository;

    /**
     * construct 
     *
     * @param App\Services\Account          $account        account
     * @param App\Repositories\MenuRepository $menuRepository menuRepository
     */
    public function __construct(AccountService $accountService, MenuRepository $menuRepository)
    {
        $this->accountService = $accountService;

        $this->menuRepository = $menuRepository;
    }

    /**
     * 取得公众号的菜单
     *
     * @return array 菜单信息
     */
    public function getMenus()
    {
        $appId = $this->accountService->getCurrent()->app_id;

        $secret = $this->accountService->getCurrent()->app_secret;

        return with(new WechatMenu(['app_id' => $appId, 'secret' => $secret]))->get();
    }

    /**
     * 提交菜单到微信
     *
     * @param array $menus 菜单
     */
    public function setMenu($menus)
    {
        
    }
}