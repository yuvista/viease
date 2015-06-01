<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * 登录 & 注册
 */
class AuthController extends Controller
{
    public function getLogin()
    {
        return view('admin.auth.login');
    }

    public function getRegister()
    {
        return view('admin.auth.register');
    }
}