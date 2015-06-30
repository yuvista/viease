<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Reply\CreateRequest;
use App\Http\Requests\Reply\UpdateRequest;
use App\Http\Requests\Reply\EventRequest;
use App\Services\Reply as ReplyService;
use App\Repositories\ReplyRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * 自动回复管理.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class ReplyController extends Controller
{
    /**
     * 默认分页数量.
     *
     * @var int
     */
    private $pageSize = 10;

    /**
     * replyRepository.
     *
     * @var App\Repositories\ReplyRepository
     */
    private $replyRepository;

    /**
     * replyService.
     *
     * @var [type]
     */
    private $replyService;

    /**
     * construct.
     *
     * @param ReplyRepository $autoReply
     */
    public function __construct(ReplyRepository $replyRepository, ReplyService $replyService)
    {
        $this->replyService = $replyService;

        $this->replyRepository = $replyRepository;
    }

    /**
     * 获取自动回复.
     */
    public function getIndex()
    {
        return admin_view('reply.index');
    }

    /**
     * 获取无匹配回复的值.
     */
    public function getFollowReply()
    {
        $accountId = account()->getCurrent()->id;

        $reply = $this->replyRepository->getFollowReply($accountId);

        return $this->replyService->resolveEventReply($reply);
    }

    /**
     * 获取无匹配时的自动回复.
     */
    public function getNoMatchReply()
    {
        $accountId = account()->getCurrent()->id;

        return $this->replyRepository->getNoMatchReply($accountId);
    }

    /**
     * 取得自动回复的列表.
     *
     * @param Request $request request
     */
    public function getList(Request $request)
    {
        $accountId = account()->getCurrent()->id;

        $pageSize = $request->get('page', $this->pageSize);

        return $this->replyRepository->getList($accountId, $pageSize);
    }

    /**
     * 新增与保存事件自动回复[ 关注与无匹配 ].
     *
     * @param EventRequest $request request
     */
    public function postSaveEventReply(EventRequest $request)
    {
        $accountId = account()->getCurrent()->id;

        $reply = $this->replyRepository->saveEventReply($request, $accountId);

        return $this->replyService->resolveEventReply($reply);
    }

    /**
     * 保存自动回复内容.
     *
     * @param CreateRequest $request request
     *
     * @return Response
     */
    public function postStore(CreateRequest $request)
    {
        $accountId = account()->getCurrent()->id;
    }

    /**
     * 更改自动回复内容.
     *
     * @param UpdateRequest $request request
     * @param int           $id      id
     *
     * @return Response
     */
    public function postUpdate(UpdateRequest $request, $id)
    {
        $accountId = account()->getCurrent()->id;
    }
}
