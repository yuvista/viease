<?php

namespace App\Services;

use Overtrue\Wechat\MenuItem as WechatMenuItem;
use App\Services\Account as AccountService;
use App\Services\Article as ArticleService;
use Overtrue\Wechat\Menu as WechatMenu;
use App\Services\Event as EventService;
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
     * 图文服务
     *
     * @var App\Services\ArticleService
     */
    private $articleService;

    /**
     * event服务
     *
     * @var App\Services\Event
     */
    private $eventService;


    private $material = [];

    /**
     * construct 
     *
     * @param App\Services\Account          $account        account
     * @param App\Repositories\MenuRepository $menuRepository menuRepository
     * @param App\Services\Event $eventService eventService
     * @param App\Services\ArticleService $articleService articleService
     */
    public function __construct(
        AccountService $accountService, 
        MenuRepository $menuRepository, 
        EventService $eventService,
        articleService $articleService)
    {
        $this->accountService = $accountService;

        $this->menuRepository = $menuRepository;

        $this->eventService = $eventService;

        $this->articleService = $articleService;
    }

    /**
     * 取得公众号的菜单
     *
     * @return array 菜单信息
     */
    public function getMenus()
    {
        return json_decode('{"is_menu_open":1,"selfmenu_info":{"button":[{"type":"text","name":"回复文字","value":"这是初次"},{"name":"回复素材","sub_button":{"list":[{"type":"img","name":"回复图片","value":"s63w7xT2JQp3jRwaHgphtm17rFMRJ6ELJKxb6Lz_Ah0GScEYTsQl8QjCe4VFZMJB"},{"type":"news","name":"回复图文","news_info":{"list":[{"title":"123123","author":"21312313","digest":"12312312","show_cover":1,"cover_url":"http:\/\/mmbiz.qpic.cn\/mmbiz\/6WSbicEHejnhNSJScRGEkqiaI0YtCkG51cSZ3MwpYp9EohaDGfMYDgdUd4mNzUnrrma2jwpzgzq4AMIicITrxWk4w\/0?wx_fmt=jpeg","content_url":"http:\/\/mp.weixin.qq.com\/s?__biz=MzAwNjUxODYxNA==&mid=205908485&idx=1&sn=474ed8b00fd8b8843e4edc13694ef7c5#rd","source_url":""},{"title":"123123","author":"131312","digest":"","show_cover":1,"cover_url":"http:\/\/mmbiz.qpic.cn\/mmbiz\/6WSbicEHejnhNSJScRGEkqiaI0YtCkG51cSZ3MwpYp9EohaDGfMYDgdUd4mNzUnrrma2jwpzgzq4AMIicITrxWk4w\/0?wx_fmt=jpeg","content_url":"http:\/\/mp.weixin.qq.com\/s?__biz=MzAwNjUxODYxNA==&mid=205908485&idx=2&sn=ffa8c40356023afd37872cc65fdcbc2f#rd","source_url":""}]}},{"type":"text","name":"第二次回复文字","value":"heihie"}]}},{"type":"view","name":"地图跳转","url":"http:\/\/mp.weixin.qq.com\/s?__biz=MzAwNjUxODYxNA==&mid=205908461&idx=1&sn=9e00e20a6e764e500496f9f881f09c4c&scene=18#wechat_redirect"}]}}',true);

        $appId = $this->accountService->getCurrent()->app_id;

        $secret = $this->accountService->getCurrent()->app_secret;

        return with(new WechatMenu(['app_id' => $appId, 'secret' => $secret]))->current();
    }

    /**
     * 提交菜单到微信
     *
     * @param array $menus 菜单
     */
    public function setMenu($menus)
    {
        
    }

    /**
     * 将远程菜单进行本地化
     *
     * @param  array $menus 菜单
     *
     * @return array 处理后的菜单
     */
    public function localize($menus)
    {
        $menus = $this->getMenusInfo($menus);

        if(empty($menus)){
            return [];
        }
        
        $menus = array_map([$this,'analyseMenu'], $menus);

        var_dump($menus);
    }

    /**
     * 取得菜单中的素材
     *
     * @param  array $menus 菜单
     *
     * @return array 菜单中素材列表
     */
    public function getMenuMaterial($menus)
    {
        $menus = $this->getMenusInfo($menus);
    }

    /**
     * 取得返回菜单数组中菜单信息
     *
     * @param  array $menus api返回的菜单信息
     *
     * @return array
     */
    public function getMenusInfo($menus)
    {
        return $menus['selfmenu_info']['button'];
    }

    /**
     * 分析菜单数据
     *
     * @param  array  $menu 菜单
     *
     * @return array
     */
    public function analyseMenu($menu)
    {
        if(isset($menu['sub_button']['list']))
        {
            $menu = array_map([$this, 'analyseMenu'], $menu['sub_button']['list']);
        }else{
            $menu = call_user_func([$this, hump('resolve_'.$menu['type'].'_menu')],$menu);
        }

        return $menu;
    }

    /**
     * 解析文字类型的菜单 [转换为事件]
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    public function resolveTextMenu($menu)
    {
        $menu['type'] = 'click';

        $menu['key'] = $this->eventService->buildText($menu['value']);

        unset($menu['value']);

        return $menu;
    }

    /**
     * 解析MediaId类型的菜单 [转换事件,存储素材]
     *
     * @param  array $menu 菜单
     *
     * @return array 
     */
    public function resolveMediaIdMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析图片类型的菜单 [转换为事件]
     *
     * @param  array $menu 菜单
     *
     * @return array
     */
    public function resolveImgMenu($menu)
    {
        $menu['type'] = 'click';

        $menu['key'] = $menu['value'];

        unset($menu['value']);

        return $menu;
    }

    /**
     * 解析新闻类型的菜单 [转换为事件/存储图文为素材]
     *
     * @param  array $menu 菜单
     *
     * @return array
     */
    public function resolveNewsMenu($menu)
    {
        $menu['type'] = 'click';

        $articleId = $this->articleService->saveRemoteArticle($menu['news_info']['list']);

        //$menu['key'] = $this->articleService->saveArticle($menu['news_info']['list']);

        unset($menu['news_info']);

        return $menu;
    }

    /**
     * 解析地址类型菜单 不用处理
     *
     * @param  array $menu 菜单
     *
     * @return array
     */
    public function resolveViewMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析点击事件类型的菜单 [无法处理]
     *
     * @return void
     */
    public function resolveClickMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析弹出摄像头类型菜单
     *
     * @param  array $menu 菜单
     *
     * @return array
     */
    public function resolvePicSysphotoMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析微信相册类型菜单
     *
     * @param  array $menu 菜单
     *
     * @return array
     */
    public function resolvePicWeixinMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析弹出拍照或者相册发图类型菜单
     *
     * @param  array $menu 菜单
     *
     * @return array
     */
    public function resolvePicPhotoOrAlbumMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析选择地理位置类型菜单
     *
     * @param  array $menu 菜单
     *
     * @return array
     */
    public function resolveLocationSelectMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析扫码推事件类型菜单
     *
     * @param  array $menu 菜单
     *
     * @return array
     */
    public function resolveScancodePushMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析扫码推事件且弹出“消息接收中”提示框类型菜单
     *
     * @param  array $menu $menu
     *
     * @return array
     */
    public function resolveScancodeWaitmsgMenu($menu)
    {
        return $menu;
    }
}