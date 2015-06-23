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
     * account服务
     *
     * @var App\Services\Account
     */
    private $accountService;

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
    public function __construct(Event $event, AccountService $accountService)
    {
        $this->model = $event;

        $this->accountService = $accountService;
    }

    /**
     * 存储一个文字回复类型事件.
     *
     * @param string $text 回复内容
     */
    public function storeText($text)
    {
        $model = new $this->model();

        $model->account_id = $this->accountService->getId();

        $model->type = 'text';

        $model->content = $text;

        $model->save();

        return $model->key;
    }
}
