<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * 二维码
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class QRCodeController extends Controller
{
    /**
     * 首页
     *
     * @return Response
     */
    public function getIndex()
    {
        return view('admin.qrcode.index');
    }
}