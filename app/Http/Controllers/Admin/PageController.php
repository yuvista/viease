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

    public function getDivTable()
    {
        return view('admin.div-table');
    }

    /**
     * 展示页
     *
     * @return void
     */
    public function getDemo()
    {
        return view('admin.demo');
    }
}