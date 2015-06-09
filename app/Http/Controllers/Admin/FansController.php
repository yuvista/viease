<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * 粉丝管理
 *
 * @author overtrue <i@overtrue.me>
 */
class FansController extends Controller
{
    public function getIndex()
    {
        return view('admin.fans.index');
    }
}
