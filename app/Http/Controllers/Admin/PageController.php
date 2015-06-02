<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * 布局控制器
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class PageController extends Controller
{
    /**
     * 后台首页展示
     *
     * @return void
     */
    public function getIndex()
    {
        return view('admin.index');
    }

    public function getDivTable()
    {
        return view('admin.div-table');
    }
}