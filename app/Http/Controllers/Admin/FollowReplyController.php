<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\FollowReplyRepository;
use App\Http\Controllers\Controller;

/**
 * 关注回复.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class FollowReplyController extends Controller
{
    /**
     * AutoReplyRepository.
     *
     * @var App\Repositories\FollowReplyRepository
     */
    private $followReply;

    /**
     * construct.
     *
     * @param FollowReplyRepository $followReply
     */
    public function __construct(FollowReplyRepository $followReply)
    {
        $this->followReply = $followReply;
    }

    /**
     * 取得关注回复的参数.
     */
    public function getIndex()
    {
        return admin_view('follow-reply.index');
    }
}
