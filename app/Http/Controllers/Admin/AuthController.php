<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 登录
 */
class AuthController extends Controller
{

    /**
     * 登录页
     *
     * @return Response
     */
    public function getLogin()
    {
        if (Auth::check()) {
            return redirect($request->get('redirect', '/'));
        }

        return view('admin.auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:5', 'password' => 'required',
        ]);

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return redirect($request->get('redirect', '/'));
        }

        return redirect()
            ->back()
            ->withInput($request->except('password'))
            ->withErrors([
                'name' => '用户名或密码错误！',
            ]);
    }
}