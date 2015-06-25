<?php

namespace App\Services;

use Overtrue\Wechat\Menu as WechatMenu;
use App\Services\Event as EventService;
use App\Repositories\MenuRepository;

/**
 * 菜单服务提供类.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Menu
{
    /**
     * menuRepository.
     *
     * @var App\Repositories\MenuRepository
     */
    private $menuRepository;

    /**
     * event服务
     *
     * @var App\Services\Event
     */
    private $eventService;

    private $material = [];

    /**
     * construct.
     *
     * @param App\Repositories\MenuRepository $menuRepository menuRepository
     * @param App\Services\Event              $eventService   eventService
     */
    public function __construct(
        MenuRepository $menuRepository,
        EventService $eventService
    ) {
        $this->menuRepository = $menuRepository;

        $this->eventService = $eventService;
    }

    /**
     * 取得远程公众号的菜单.
     *
     * @return array 菜单信息
     */
    public function getFromRemote()
    {
        return json_decode('{"is_menu_open":1,"selfmenu_info":{"button":[{"type":"news","name":"1","news_info":{"list":[{"title":"002","author":"","digest":"111111","show_cover":1,"cover_url":"http:\/\/mmbiz.qpic.cn\/mmbiz\/6WSbicEHejnhAvUutRuiaWIWJtuSia01qQibU6vGMhVWWSIVxwlfxvibCjj3qnXUfQdy21vs0HZ5icy45YMYRpqNP44g\/0?wx_fmt=jpeg","content_url":"http:\/\/mp.weixin.qq.com\/s?__biz=MzAwNjUxODYxNA==&mid=205824034&idx=1&sn=b369926ad11ad98868bb7936e5f5bc93#rd","source_url":""}]}},{"type":"img","name":"31231","value":"lcJ0yWx9ADHQdyFPTN3ZISmVLwHdQ4p-D4J9NELhazw08K8QxEDFd470PuJvwDHJ"}]}}', true);

        $appId = account()->getCurrent()->app_id;

        $secret = account()->getCurrent()->app_secret;

        return with(new WechatMenu(['app_id' => $appId, 'secret' => $secret]))->current();
    }

    /**
     * 提交菜单到微信
     *
     * @param array $menus 菜单
     */
    public function saveToRemote($menus)
    {
    }

    /**
     * 将远程菜单进行本地化.
     *
     * @param array $menus 菜单
     *
     * @return array 处理后的菜单
     */
    private function localize($menus)
    {
        $menus = $menus['selfmenu_info']['button'];

        if (empty($menus)) {
            return [];
        }

        $menus = array_map([$this, 'analyseMenu'], $menus);

        return $menus;
    }

    /**
     * 同步远程菜单到本地数据库.
     */
    public function sync()
    {
        $remoteMenus = $this->getFromRemote();

        $menus = $this->localize($remoteMenus);

        return $this->saveToLocal($menus);
    }

    /**
     * 保存解析后台的菜单到本地.
     *
     * @param array $menus 菜单
     *
     * @return array
     */
    private function saveToLocal($menus)
    {
        $accountId = account()->getCurrent()->id;

        return $this->menuRepository->storeMulti($accountId, $menus);
    }

    /**
     * 分析菜单数据.
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function analyseMenu($menu)
    {
        if (isset($menu['sub_button']['list'])) {
            $menu['sub_button'] = array_map([$this, 'analyseMenu'], $menu['sub_button']['list']);
        } else {
            $menu = call_user_func([$this, camel_case('resolve_'.$menu['type'].'_menu')], $menu);
        }

        return $menu;
    }

    /**
     * 解析文字类型的菜单 [转换为事件].
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolveTextMenu($menu)
    {
        $menu['type'] = 'click';

        $menu['key'] = $this->eventService->makeText($menu['value']);

        unset($menu['value']);

        return $menu;
    }

    /**
     * 解析MediaId类型的菜单 [转换事件,存储素材].
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolveMediaIdMenu($menu)
    {
        $menu['type'] = 'click';

        $menu['key'] = $this->eventService->makeMediaId($menu['value']);

        unset($menu['value']);

        return $menu;
    }

    /**
     * 解析图片类型的菜单 [转换为事件].
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolveImgMenu($menu)
    {
        $menu['type'] = 'click';

        $menu['key'] = $this->eventService->makeMediaId($menu['value']);

        unset($menu['value']);

        return $menu;
    }

    /**
     * 解析新闻类型的菜单 [转换为事件/存储图文为素材].
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolveNewsMenu($menu)
    {
        $menu['type'] = 'click';

        $menu['key'] = $this->eventService->makeNews($menu['news_info']['list']);

        unset($menu['news_info']);

        return $menu;
    }

    /**
     * 解析地址类型菜单 不用处理.
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolveViewMenu($menu)
    {
        $menu['key'] = $menu['url'];

        unset($menu['url']);

        return $menu;
    }

    /**
     * 解析点击事件类型的菜单 [自己的保留，否则丢弃].
     */
    private function resolveClickMenu($menu)
    {
        if(!$this->eventService->isOwnEvent($menu['key'])){
            $menu['key'] = Null;
        }

        return $menu;
    }

    /**
     * 解析弹出摄像头类型菜单.
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolvePicSysphotoMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析微信相册类型菜单.
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolvePicWeixinMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析弹出拍照或者相册发图类型菜单.
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolvePicPhotoOrAlbumMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析选择地理位置类型菜单.
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolveLocationSelectMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析扫码推事件类型菜单.
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolveScancodePushMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析扫码推事件且弹出“消息接收中”提示框类型菜单.
     *
     * @param array $menu $menu
     *
     * @return array
     */
    private function resolveScancodeWaitmsgMenu($menu)
    {
        return $menu;
    }

    /**
     * 解析跳转图文MediaIdUrl类型的菜单[将被转换为View类型].
     *
     * @param array $menu 菜单
     *
     * @return array
     */
    private function resolveViewLimitedMenu($menu)
    {
        $menu['type'] = 'view';

        $url = 'http://www.badiu.com';

        $menu['key'] = $url;

        unset($menu['value']);

        return $menu;
    }
}
