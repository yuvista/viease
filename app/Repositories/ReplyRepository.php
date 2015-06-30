<?php

namespace App\Repositories;

use App\Models\Reply;

/**
 * Reply Repository.
 */
class ReplyRepository
{
    use BaseRepository;

    /**
     * model.
     *
     * @var App\Models\Reply
     */
    private $model;

    /**
     * eventRepository.
     *
     * @var App\Repositories\EventRepository
     */
    private $eventRepository;

    /**
     * construct.
     *
     * @param Reply           $reply           replyModel
     * @param EventRepository $eventRepository eventRepository
     */
    public function __construct(Reply $reply, EventRepository $eventRepository)
    {
        $this->model = $reply;

        $this->eventRepository = $eventRepository;
    }

    /**
     * 获取关注时的默认回复.
     *
     * @param int $accountId accountId
     *
     * @return array|mixed
     */
    public function getFollowReply($accountId)
    {
        return $this->model->where('type', Reply::TYPE_FOLLOW)->where('account_id', $accountId)->first();
    }

    /**
     * 取得关注时的默认回复.
     *
     * @param int $accountId accountId
     *
     * @return array|mixed
     */
    public function getNoMatchReply($accountId)
    {
        return $this->model->where('type', Reply::TYPE_NO_MATCH)->where('account_id', $accountId)->first();
    }

    /**
     * 获取自动回复列表.
     *
     * @param int $accountId accountId
     * @param int $pageSize  分页数目
     *
     * @return array
     */
    public function getList($accountId, $pageSize)
    {
        return $this->model->where('type', Reply::TYPE_KEYWORDS)->where('account_id', $accountId)->get();
    }

    /**
     * 保存事件自动回复.
     *
     * @param App\Http\Requests\Reply\EventRequest $request   request
     * @param int                                  $accountId accountId
     */
    public function saveEventReply($request, $accountId)
    {
        $replyContent = $request->reply_content;

        $replyType = $request->reply_type;

        $type = $request->type;

        $model = $this->model->firstOrCreate([
                'account_id' => $accountId,
                'type' => $type,
            ]);

        if ($model) {
            $this->saveToEvent($replyType, $content, $accountId);
        } else {
            $this->updateEvent($replyType, $content, $accountId);
        }

        $input = $request->all();

        unset($input['reply_content'], $input['reply_type']);

        $input['account_id'] = $accountId;

        $input['content'] = [$eventId];

        return $this->savePost($model, $input);
    }

    /**
     * 新增一个事件到关注或无匹配回复.
     *
     * @param string $replyType 回复类型
     * @param string $content   回复内容
     * @param int    $accountId accountId
     *
     * @return string eventId
     */
    private function saveToEvent($replyType, $content, $accountId)
    {
        if ($replyType == 'text') {
            $eventId = $this->eventRepository->storeText($replyContent, $accountId);
        } else {
            $eventId = $this->eventRepository->storeMaterial($replyContent, $accountId);
        }

        return $eventId;
    }

    private function updateEvent($replyType, $content, $accountId)
    {
    }

    /**
     * 存储回复.
     *
     * @param request $request   request
     * @param int     $accountId accountId
     *
     * @return Reply 模型
     */
    public function store($request, $accountId)
    {
    }

    /**
     * 保存.
     *
     * @param App\Models\Reply $reply reply
     * @param array            $input input
     *
     * @return Reply 返回模型
     */
    public function savePost($reply, $input)
    {
        $reply->fill($input);

        $reply->save();

        return $reply;
    }
}
