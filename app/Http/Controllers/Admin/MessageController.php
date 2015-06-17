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
     * @return void
     */
    public function getIndex()
    {

    }
}