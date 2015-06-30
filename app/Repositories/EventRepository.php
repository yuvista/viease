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
     * 通过eventId查询.
     *
     * @param string $eventId eventId
     *
     * @return Event event
     */
    public function findByEventId($eventId)
    {
        return $this->model->where('key', $eventId)->first();
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

        $model->type = 'text';

        $model->content = $text;

        $model->save();

        return $model->key;
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

        $model->content = $mediaId;

        $model->save();

        return $model->key;
    }
}
