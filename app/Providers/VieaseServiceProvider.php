<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Account;
use App\Repositories\AccountRepository;
use App\Models\Account as AccountModel;

class VieaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton('Viease\Account', function () {
            $model = new AccountModel();
            $repositorie = new AccountRepository($model);

            return new Account($repositorie);
        });
    }
}
