<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Article\CreateRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Repositories\ArticleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * 图文管理
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class ArticleController extends Controller
{
    /**
     * 图文管理首页
     *
     * @return void
     */
    public function getIndex()
    {
        return view('admin.article.index');
    }
}