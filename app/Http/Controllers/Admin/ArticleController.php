<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Article\CreateRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Repositories\ArticleRepository;
use App\Http\Controllers\Controller;

/**
 * 图文管理.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class ArticleController extends Controller
{
    /**
     * articleRepository
     *
     * @var App\Repositories\ArticleRepository
     */
    private $articleRepository;

    /**
     * 每页显示数量
     *
     * @var integer
     */
    private $pageSize = 10;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * 图文管理首页.
     *
     * @return  Reponse 
     */
    public function getIndex()
    {
        return admin_view('article.index');
    }

    /**
     * 图文列表
     *
     * @return Reponse
     */
    public function getLists()
    {
        $accountId = account()->getCurrent()->id;

        return $this->articleRepository->lists($accountId,$this->pageSize);
    }

    /**
     * 图文消息
     *
     * @return Reponse
     */
    public function getCreate()
    {
        return admin_view('article.create');
    }

    /**
     * 新增图文消息
     *
     * @param  CreateRequest $request request
     *
     * @return void
     */
    public function postCreate(CreateRequest $request)
    {
        return $this->articleRepository->store($request);
    }

    /**
     * 展示修改
     *
     * @param  integer $id id
     *
     * @return void
     */
    public function getUpdate($id)
    {
        $article = $this->articleRepository->getById($id);

        return admin_view('article.update', compact('article'));
    }

    /**
     * 提交修改
     *
     * @param  UpdateRequest $request request
     * @param  integer $id id
     *
     * @return void
     */
    public function postUpdate(UpdateRequest $request, $id)
    {
        return $this->articleRepository->update($id, $request);

        return redirect(admin_url('article'))->withMessage('修改成功！');
    }
}
