<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Account\CreateRequest;
use App\Http\Requests\Account\UpdateRequest;
use App\Repositories\AccountRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * 公众号管理
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class AccountController extends Controller
{

    /**
     * AccountRepository
     *
     * @var AccountRepository
     */
    protected $account;

    /**
     * constructer
     *
     * @param AccountRepository $account
     */
    public function __construct(AccountRepository $account)
    {
        $this->account = $account;
    }

    /**
     * 展示公众号
     *
     * @return Response
     */
    public function getIndex()
    {
        $accounts = $this->account->lists(10);

        return view('admin.account.index', compact('accounts'));
    }

    /**
     * 添加公众号
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('admin.account.form');
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
}