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
        return view('admin.message.index');
    }

    /**
     * 实时消息
     *
     * @return Response
     */
    public function getTimeline()
    {
        return view('admin.message.timeline');
    }

    /**
     * 广播消息
     *
     * @return Response
     */
    public function getBroadcasting()
    {
        return view('admin.message.broadcasting');
    }

    /**
     * 消息资源
     *
     * @return Response
     */
    public function getResource()
    {
        return view('admin.message.resource');
    }
}