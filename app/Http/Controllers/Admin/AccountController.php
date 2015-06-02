<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * 公众号管理
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class AccountController extends Controller
{
    /**
     * 展示公众号
     *
     * @return Response
     */
    public function getIndex()
    {
        return view('admin.account.index');
    }

    /**
     * 添加公众号
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('admin.account.create');
    }

    public function postCreate()
    {

    }
}