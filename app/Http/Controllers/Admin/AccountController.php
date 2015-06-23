<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Account\CreateRequest;
use App\Http\Requests\Account\UpdateRequest;
use App\Services\Account as AccountService;
use App\Repositories\AccountRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Account;
use Event;

/**
 * 公众号管理
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class AccountController extends Controller
{

    /**
     * 分页
     *
     * @var integer
     */
    private $_pageSize = 10;

    /**
     * AccountRepository
     *
     * @var AccountRepository
     */
    private $account;

    /**
     * App\Services\Account
     *
     * @var App\Services\Account
     */
    private $service;

    /**
     * constructer
     *
     * @param AccountRepository $account
     */
    public function __construct(AccountRepository $account, AccountService $service)
    {
        $this->account = $account;

        $this->service = $service;

        $this->middleware('account', ['only' => 'getManage']);
    }

    /**
     * 展示公众号
     *
     * @return Response
     */
    public function getIndex()
    {
        $accounts = $this->account->lists($this->_pageSize);

        return admin_view('account.index', compact('accounts'));
    }

    /**
     * 预览首页
     *
     * @return void
     */
    public function getManage()
    {
        $current = $this->service->getCurrent();

        return admin_view('account.manage', compact('current'));
    }

    /**
     * 添加公众号
     *
     * @return Response
     */
    public function getCreate()
    {
        return admin_view('account.form');
    }

    /**
     * 创建账户
     *
     * @param CreateRequest $request
     *
     * @return Redirect
     */
    public function postCreate(CreateRequest $request)
    {
        $this->account->store($request);

        return redirect(admin_url('account'))->withMessage('添加成功！');
    }

    /**
     * 展示修改
     *
     * @param integer $id id
     *
     * @return void
     */
    public function getUpdate($id)
    {
        $account = $this->account->getById($id);

        return admin_view('account.form', compact('account'));
    }

    /**
     * 提交
     *
     * @param integer       $id      id
     * @param UpdateRequest $request request
     *
     * @return Redirect
     */
    public function postUpdate(UpdateRequest $request, $id)
    {
        $this->account->update($id, $request);

        return redirect(admin_url('account'))->withMessage('修改成功！');
    }

    /**
     * 删除公众号
     *
     * @param ineger $id 公众号iD
     *
     * @return void
     */
    public function getDelete($id)
    {
        $this->account->destroy($id);

        return redirect(admin_url('account'))->withMessage('删除成功！');
    }

    /**
     * 切换公众号
     *
     * @param integer $id id
     *
     * @return void
     */
    public function getChangeAccount($id)
    {
        $this->service->chose($id);

        return redirect(admin_url('/'));
    }
}
