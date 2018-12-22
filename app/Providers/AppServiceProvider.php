<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Chatkit', function() {
            $instanceLocator = config('services.chatkit.instanceLocator');
            $secret = config('services.chatkit.secret');

            return new \App\Chatkit([
                'instance_locator' => $instanceLocator,
                'key' => $secret
            ]);
        });
    }
}
