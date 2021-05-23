<?php

namespace App\Providers;

use App\Http\View\Composers\NotificationComposer;
use App\Http\View\Composers\UserComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (App::environment(['production'])) {
            Config::set('app.asset_url', 'http://eapis.ncip-hrmd.com/public');
        }

        Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        View::composer('*', NotificationComposer::class);
        View::composer('*', UserComposer::class);
    }
}
