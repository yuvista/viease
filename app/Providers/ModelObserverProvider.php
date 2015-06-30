<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Event;
use App\Models\Material;
use App\Models\Account;
use Illuminate\Support\ServiceProvider;

class ModelObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        User::observe('App\Observers\UserObserver');
        Event::observe('App\Observers\EventObserver');
        Material::observe('App\Observers\MaterialObserver');
        Account::observe('App\Observers\AccountObserver');
    }

    public function register()
    {
        # code...
    }
}
