<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * 图文管理.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class ArticleController extends Controller
{
    /**
     * 图文管理首页.
     */
    public function getIndex()
    {
        return admin_view('article.index');
    }
}
