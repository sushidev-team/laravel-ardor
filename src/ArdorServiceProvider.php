<?php

namespace AMBERSIVE\Ardor;

use Illuminate\Support\ServiceProvider;

class ArdorServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Configs
        $this->publishes([
            __DIR__.'/Configs/ardor.php'         => config_path('ardor.php'),
        ],'ardor');

        $this->mergeConfigFrom(
            __DIR__.'/Configs/ardor.php', 'ardor.php'
        );

        // Commands
        if ($this->app->runningInConsole()) {
            $this->commands([
               \AMBERSIVE\Ardor\Console\Commands\ArdorRunBundler::class,
               \AMBERSIVE\Ardor\Console\Commands\ArdorRunContracts::class,
            ]);
        }

    }

}
