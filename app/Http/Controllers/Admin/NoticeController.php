<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * 模板消息.
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class NoticeController extends Controller
{
    /**
     * 模板消息首页.
     */
    public function getIndex()
    {
        return admin_view('notice.index');
    }
}
