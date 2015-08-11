<?php

namespace App\Repositories;

use App\Services\Account as AccountService;
use App\Models\Event;

/**
 * Event Repository.
 */
class EventRepository
{
    use BaseRepository;

    /**
     * Event Model.
     *
     * @var Event
     */
    protected $model;

    /**
     * construct.
     *
     * @param Event          $event          event
     * @param AccountService $accountService AccountService
     */
    public function __construct(Event $event)
    {
        $this->model = $event;
    }

    /**
     * 通过key查询event.
     *
     * @param string $eventId eventId
     *
     * @return Event event
     */
    public function getEventByKey($eventId)
    {
        return $this->model->where('key', $eventId)->first();
    }

    /**
     * 通过key删除事件.
     *
     * @param string $eventId eventId
     */
    public function distoryByEventKey($eventKey)
    {
        return $this->model->where('key', $eventKey)->delete();
    }

    /**
     * 存储一个文字回复类型事件.
     *
     * @param string $text      回复内容
     * @param int    $accountId
     *
     * @return string key
     */
    public function storeText($text, $accountId)
    {
        $model = new $this->model();

        $model->account_id = $accountId;

        $model->type = 'material';

        $model->value = $text;

        $model->save();

        return $model->key;
    }

    /**
     * 更新一个文字类型回复事件.
     *
     * @param string $eventId   事件ID
     * @param string $text      文字回复内容
     * @param int    $accountId accountID
     */
    public function updateToText($eventId, $text)
    {
        $model = $this->findByEventId($eventId);

        $model->type = 'material';

        $model->value = $text;

        $model->save();
    }

    /**
     * 更新一个素材类型回复事件.
     *
     * @param string $eventId   事件id
     * @param string $mediaId   mediaId
     * @param int    $accountId accountId
     */
    public function updateToMaterial($eventId, $mediaId)
    {
        $model = $this->findByEventId($eventId);

        $model->type = 'material';

        $model->value = $mediaId;

        $model->save();
    }

    /**
     * 存储一个素材回复类型的事件.
     *
     * @param string $mediaId   素材id
     * @param int    $accountId accountId
     *
     * @return string mediaId
     */
    public function storeMaterial($mediaId, $accountId)
    {
        $model = new $this->model();

        $model->account_id = $accountId;

        $model->type = 'material';

        $model->value = $mediaId;

        $model->save();

        return $model->key;
    }
}
