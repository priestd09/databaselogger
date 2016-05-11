<?php
/**
 * Created by PhpStorm.
 * User: Fabian
 * Date: 08.05.16
 * Time: 07:22
 */

namespace Brotzka\Databaselogger;

use Illuminate\Support\ServiceProvider;

class DatabaseloggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('brotzka-databaselogger', function() {
            return new Databaselogger;
        });

        $this->mergeConfigFrom(__DIR__ . '/config/databaselogger.php', 'brotzka-databaselogger');
    }

    public function boot(){

        $this->loadViewsFrom(__DIR__ . '/views', 'brotzka-databaselogger');
        $this->publishes(
            [__DIR__ . '/views' => base_path('resources/views/vendor/brotzka-databaselogger')],
            'views'
        );

        $this->publishes(
            // Keep the config_path() empty, so the config file will be published directly to the config directory
            [__DIR__ . '/config' => config_path()],
            'config'
        );

        $this->publishes([
            __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');
    }
}