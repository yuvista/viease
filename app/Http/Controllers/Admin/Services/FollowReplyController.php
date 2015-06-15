<?php

namespace App\Http\Controllers\Admin\Services;

use App\Http\Requests\FollowReply\CreateRequest;
use App\Http\Requests\FollowReply\UpdateRequest;
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
     * 取得关注回复的参数
     *
     * @return void
     */
    public function getIndex()
    {
        
    }
}