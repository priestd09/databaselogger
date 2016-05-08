<?php
/**
 * Created by PhpStorm.
 * User: Fabian
 * Date: 08.05.16
 * Time: 07:22
 */

namespace Fabs87\Databaselogger;

use Illuminate\Support\ServiceProvider;

class DatabaseloggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('fabs87-demo', function() {
            return new Databaselogger;
        });
    }
}