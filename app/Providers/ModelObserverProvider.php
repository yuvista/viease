<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Event;
use App\Models\Article;
use App\Models\Material;
use App\Models\Account;
use App\Models\Fan;
use App\Models\FanGroup;
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
        Article::observe('App\Observers\ArticleObserver');
        Material::observe('App\Observers\MaterialObserver');
        Account::observe('App\Observers\AccountObserver');
		FanGroup::observe('App\Observers\FanGroupObserver');
		Fan::observe('App\Observers\FanObserver');
    }

    public function register()
    {
        # code...
    }
}
