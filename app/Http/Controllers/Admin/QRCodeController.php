<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * 二维码.
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class QRCodeController extends Controller
{
    /**
     * 首页.
     *
     * @return Response
     */
    public function getIndex()
    {
        return admin_view('qrcode.index');
    }
}
