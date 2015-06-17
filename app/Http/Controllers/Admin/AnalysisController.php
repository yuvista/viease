<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * 数据统计与分析
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class AnalysisController extends Controller
{
    /**
     * 首页
     *
     * @return Response
     */
    public function getIndex()
    {
        return view('admin.analysis.index');
    }

    /**
     * 粉丝
     *
     * @return Response
     */
    public function getFan()
    {
        return view('admin.analysis.fan');
    }

    /**
     * 图文
     *
     * @return Response
     */
    public function getArticle()
    {
        return view('admin.analysis.article');
    }

    /**
     * 消息
     *
     * @return Response
     */
    public function getMessage()
    {
        return view('admin.analysis.message');
    }

    /**
     * 接口
     *
     * @return Response
     */
    public function getApi()
    {
        return view('admin.analysis.api');
    }
}