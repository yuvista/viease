<?php

namespace App\Services;

use App\Repositories\EventRepository;

/**
 * 事件服务提供.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Event
{
    /**
     * EventRepository.
     *
     * @var App\Repositories\EventRepository
     */
    private $eventRepository;

    /**
     * construct description.
     *
     * @param App\Repositories\EventRepository $eventRepository
     */
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * 是否属于自己的事件.
     *
     * @param string $name name
     *
     * @return bool
     */
    public function isOwnEvent($name)
    {
        return starts_with($name, 'V_EVENT_');
    }

    /**
     * 创建一个文字类型的事件.
     *
     * @param int    $accountId 公众号Id
     * @param string $text      返回值
     *
     * @return string 事件key
     */
    public function makeText($accountId, $text)
    {
        return $this->eventRepository->storeText($text, $accountId);
    }

    /**
     * 创建一个mediaId类型的事件.
     *
     * @param int    $accountId 公众号Id
     * @param string $mediaId   本地素材Id
     *
     * @return string 事件key
     */
    public function makeMediaId($accountId, $mediaId)
    {
        return $this->eventRepository->storeMaterial($mediaId, $accountId);
    }

    /**
     * 创建key名称.
     *
     * @return string
     */
    public function makeEventKey()
    {
        return 'V_EVENT_'.strtoupper(uniqid());
    }

    /**
     * 通过ID得到Event.
     *
     * @param string $eventId 事件id
     *
     * @return Response
     */
    public function getEventByKey($eventId)
    {
        return $this->eventRepository->getEventByKey($eventId);
    }

    /**
     * 将event转变为素材.
     *
     * @param string $event eventId
     *
     * @return array
     */
    public function eventToMaterial($eventId)
    {
        $event = $this->eventRepository->getEventByKey($eventId);

        return $event;
    }

    /**
     * 根据eventId 删除事件.
     *
     * @param string $eventKey 事件key
     */
    public function distoryByEventKey($eventKey)
    {
        return $this->eventRepository->distoryByEventKey($eventKey);
    }
}
