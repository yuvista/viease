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
     * 存储一个文字回复类型事件.
     *
     * @param string $text 回复内容
     *
     * @return string key
     */
    public function storeText($text)
    {
        $model = new $this->model();

        $model->account_id = account()->getCurrent()->id;

        $model->type = 'text';

        $model->content = $text;

        $model->save();

        return $model->key;
    }

    /**
     * 存储一个图文回复事件.
     *
     * @param string $mediaId MediaId
     *
     * @return string key
     */
    public function storeNews($mediaId)
    {
        $model = new $this->model();

        $model->account_id = account()->getCurrent()->id;

        $model->type = 'article';

        $model->content = $mediaId;

        $model->save();

        return $model->key;
    }

    public function storeMaterial($mediaId)
    {
        $model = new $this->model();

        $model->account_id = account()->getCurrent()->id;

        $model->type = 'material';

        $model->content = $mediaId;

        $model->save();

        return $model->key;
    }
}
