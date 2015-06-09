<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * 用户管理
 *
 * @author overtrue <i@overtrue.me>
 */
class UserController extends Controller
{
    public function getIndex()
    {
        return view('admin.user.index');
    }
}
