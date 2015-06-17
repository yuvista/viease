<?php

namespace App\Http\Composers;

use App\Repositories\AccountRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use App\Services\Account;

/**
 * 后台视图组织
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class AdminComposer
{
    /**
     * accountRepository
     *
     * @var App\Repositories\AccountRepository
     */
    private $accountRepository;

    /**
     * request
     *
     * @var Illuminate\Http\Request
     */
    private $request;

    /**
     * accountService
     *
     * @var App\Services\Account;
     */
    private $accountService;

    /**
     * construct
     *
     * @param App\Repositories\AccountRepository $accountRepository
     */
    public function __construct(
        AccountRepository $accountRepository,
        Request $request,
        Account $accountService
        )
    {
        $this->accountRepository  = $accountRepository;

        $this->request = $request;

        $this->accountService = $accountService;
    }

    /**
     * compose
     *
     * @param  View   $view 视图对象
     *
     * @return void
     */
    public function compose(View $view)
    {
        $menus = $this->request->is('admin/account*') ? config('menu.account') : config('menu.func');

        $global = new Fluent();

        $global->menus = $menus;

        $global->current_account = $this->accountService->getCurrent();

        $global->accounts = $this->accountRepository->lists(99);

        $view->with('global', $global);
    }
}