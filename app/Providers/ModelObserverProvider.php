<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Account;
use App\Models\Menu;
use App\Models\Event;
use App\Models\Fan;
use App\Models\FanGroup;
use App\Models\Message;
use Illuminate\Support\ServiceProvider;

class ModelObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe('App\Observers\UserObserver');
        Event::observe('App\Observers\EventObserver');
    }

    public function register()
    {
        # code...
    }
}
