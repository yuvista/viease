<?php

namespace App\Services;

use App\Services\Account as AccountService;
use Overtrue\Wechat\Menu as WechatMenu;
use App\Repositories\EventRepository;


/**
 * 事件服务提供
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Event {

    /**
     * EventRepository
     *
     * @var App\Repositories\EventRepository
     */
    private $eventRepository;

    /**
     * construct description
     *
     * @param App\Repositories\EventRepository $eventRepository 
     */
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * 是否属于自己的事件
     *
     * @param  string  $name name
     *
     * @return boolean 
     */
    public function isOwnEvent($name)
    {
        return strpos($name, 'EVENT_');
    }

    /**
     * 创建一个文字类型的事件
     *
     * @param  string $text 返回值
     *
     * @return string 事件id
     */
    public function buildText($text)
    {
        return $this->eventRepository->storeText($text);
    }

    /**
     * 创建key名称
     *
     * @return string
     */
    public function buildEventKey()
    {
        return 'EVENT_'.strtoupper(uniqid());
    }
}