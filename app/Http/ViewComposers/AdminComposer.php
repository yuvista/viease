<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

/**
 * 后台视图组织
 * 
 * @author rongyouyuan <rongyouyuan@163.com>
 */
class AdminComposer
{
    /**
     * compose
     *
     * @param  View   $view 视图对象
     *
     * @return void
     */
    public function compose(View $view)
    {
        $menus = config('menu');

        $view->with('menus',$menus);
    }
}