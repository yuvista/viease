<?php

namespace App\Http\Controllers\Admin\Services;

use App\Http\Requests\FollowReply\CreateRequest;
use App\Http\Requests\FollowReply\UpdateRequest;
use App\Services\Account as AccountService;
use App\Repositories\FollowReplyRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * 关注回复
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class FollowReplyController extends Controller
{
    /**
     * account 服务
     *
     * @var App\Services\Account
     */
    private $service;

    /**
     * AutoReplyRepository
     *
     * @var App\Repositories\FollowReplyRepository
     */
    private $followReply;

    /**
     * construct
     *
     * @param AccountService        $service   
     * @param FollowReplyRepository $followReply 
     */
    public function __construct(AccountService $service,FollowReplyRepository $followReply)
    {
        $this->service = $service;

        $this->followReply = $followReply;
    }

    /**
     * 取得关注回复的参数
     *
     * @return void
     */
    public function getIndex()
    {
        
    }
}