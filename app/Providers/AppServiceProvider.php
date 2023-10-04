<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use App\Core\KTBootstrap;
use Illuminate\Database\Schema\Builder;
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
        if (App::environment(['staging', 'production'])) {
            URL::forceScheme('https');
        }

        // Update defaultStringLength
        Builder::defaultStringLength(191);

        KTBootstrap::init();
    }
}
