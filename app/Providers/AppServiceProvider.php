<?php

namespace App\Providers;

use App\Models\Profile;
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
       
        view()->composer('admin.partials.top-header', function ($view) {
            view()->share('company', Profile::first());
        });
    
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    }
}
