<?php

namespace PHP2\EmotionMaker;

use Illuminate\Support\ServiceProvider;

class EmotionMakerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'php2');
        // for users can customize their view, and run command php artisan vendor:publish
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/php2/emotion-maker'),
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
        $this->app->make('PHP2\EmotionMaker\EmotionController');
    }
}
