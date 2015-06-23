<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Event;
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
    }

    public function register()
    {
        # code...
    }
}
