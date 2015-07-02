<?php

namespace App\Services;

use App\Services\Event as EventService;

/**
 * 回复服务.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class Reply
{
    /**
     * eventService.
     *
     * @var EventService
     */
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * 解析事件回复.
     *
     * @param App\Models\Reply $reply reply
     *
     * @return array
     */
    public function resolveReply($reply)
    {
        $reply = $reply->toArray();

        $eventService = $this->eventService;

        $reply['content'] = array_map(function ($eventId) use ($eventService) {

            return $eventService->eventToMaterial($eventId);
        }, $reply['content']);

        return $reply;
    }
}
