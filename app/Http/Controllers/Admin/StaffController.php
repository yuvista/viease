<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * 客服
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class StaffController extends Controller
{
    /**
     * 首页
     *
     * @return Response
     */
    public function getIndex()
    {
        return view('admin.staff.index');
    }

    /**
     * 绩效
     *
     * @return Response
     */
    public function getPerformance()
    {
        return view('admin.staff.performance');
    }
}