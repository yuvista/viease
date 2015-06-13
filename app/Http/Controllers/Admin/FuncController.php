<?php


class FuncController
{
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
    public function __construct(AccountRepository $account,AccountService $service)
    {
        $this->account = $account;

        $this->service = $service;

        $this->middleware('account',['only' => 'getManage']);
    }


    /**
     * 功能首页
     *
     * @return void
     */
    public function getIndex()
    {
        $current = $this->service->getCurrent();

        return view('admin.account.manage',compact('current'));
    }

}
