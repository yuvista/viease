<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * 数据统计与分析.
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class AnalysisController extends Controller
{
    /**
     * 首页.
     *
     * @return Response
     */
    public function getIndex()
    {
        return admin_view('analysis.index');
    }

    /**
     * 粉丝.
     *
     * @return Response
     */
    public function getFan()
    {
        return admin_view('analysis.fan');
    }

    /**
     * 图文.
     *
     * @return Response
     */
    public function getArticle()
    {
        return admin_view('analysis.article');
    }

    /**
     * 消息.
     *
     * @return Response
     */
    public function getMessage()
    {
        return admin_view('analysis.message');
    }

    /**
     * 接口.
     *
     * @return Response
     */
    public function getApi()
    {
        return admin_view('analysis.api');
    }
}
