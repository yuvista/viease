<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * 工具.
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class ToolController extends Controller
{
    /**
     * 首页.
     *
     * @return Response
     */
    public function getIndex()
    {
        return admin_view('tool.index');
    }

    /**
     * 短网址.
     *
     * @return Response
     */
    public function getShortUrl()
    {
        return admin_view('tool.short-url');
    }
}
