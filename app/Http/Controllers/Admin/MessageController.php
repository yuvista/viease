<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Article\CreateRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Repositories\ArticleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * 消息管理
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class MessageController extends Controller
{

    /**
     * 首页
     *
     * @return Response
     */
    public function getIndex()
    {
        return admin_view('message.index');
    }

    /**
     * 实时消息
     *
     * @return Response
     */
    public function getTimeline()
    {
        return admin_view('message.timeline');
    }

    /**
     * 广播消息
     *
     * @return Response
     */
    public function getBroadcasting()
    {
        return admin_view('message.broadcasting');
    }

    /**
     * 消息资源
     *
     * @return Response
     */
    public function getResource()
    {
        return admin_view('message.resource');
    }
}
