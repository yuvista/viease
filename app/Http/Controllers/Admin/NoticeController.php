<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * 模板消息
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class NoticeController extends Controller
{
    /**
     * 模板消息首页
     *
     * @return void
     */
    public function getIndex()
    {
        return admin_view('notice.index');
    }
}