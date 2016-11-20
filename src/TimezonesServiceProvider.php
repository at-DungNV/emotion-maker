<?php

namespace DungNV\Timezones;

use Illuminate\Support\ServiceProvider;

class TimezonesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'dungnv');
        // for users can customize their view, and run command php artisan vendor:publish
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/dungnv/timezones'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';
        $this->app->make('DungNV\Timezones\TimezonesController');
        $this->app->make('DungNV\Timezones\EmotionController');
    }
}
