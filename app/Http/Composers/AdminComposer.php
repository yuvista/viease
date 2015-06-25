<?php

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use App\Services\Account;
use Auth;

/**
 * 后台视图组织.
 *
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class AdminComposer
{
    /**
     * request.
     *
     * @var Illuminate\Http\Request
     */
    private $request;

    /**
     * accountService.
     *
     * @var App\Services\Account;
     */
    private $accountService;

    public function __construct(
        Request $request,
        Account $accountService
    ) {
        $this->request = $request;

        $this->accountService = $accountService;
    }

    /**
     * compose.
     *
     * @param View $view 视图对象
     */
    public function compose(View $view)
    {
        $menus = $this->request->is('admin/account*') ? config('menu.account') : config('menu.func');

        $global = new Fluent();

        $global->user = Auth::user();

        $global->menus = $menus;

        $global->current_account = account()->getCurrent();

        $global->accounts = $this->accountService->getLists();

        $view->with('global', $global);
    }
}
