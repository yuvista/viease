<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Material\CreateRequest;
use App\Http\Requests\Material\UpdateRequest;
use App\Repositories\MaterialRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * 素材管理
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class MaterialController extends Controller
{
    /**
     * 取得素材列表
     *
     * @return void
     */
    public function getIndex()
    {
        return admin_view('material.index');
    }
}