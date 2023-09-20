<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        URL::forceScheme('http');

        Model::shouldBeStrict(env('APP_ENV', 'local') != 'production');

        LogViewer::auth(function ($request) {
            return $request->user() && in_array($request->user()->email, ['rashid.mohamad@hp.nic.in']);
        });
    }
}
