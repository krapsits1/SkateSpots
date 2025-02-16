<?php

namespace App\Providers;
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // URL::forceRootUrl(Config::get('app.url'));
        // if (Str::contains(Config::get('app.url'), 'https://')) {
        //   URL::forceScheme('https');
        // }   
     }
}
