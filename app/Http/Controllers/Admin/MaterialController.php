<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * 素材管理.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class MaterialController extends Controller
{
    /**
     * 取得素材列表.
     */
    public function getIndex()
    {
        return admin_view('material.index');
    }
}
