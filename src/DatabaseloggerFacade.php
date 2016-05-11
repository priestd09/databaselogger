<?php
/**
 * Created by PhpStorm.
 * User: Fabian
 * Date: 08.05.16
 * Time: 07:24
 */

namespace Brotzka\Databaselogger;

use Illuminate\Support\Facades\Facade;

class DatabaseloggerFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'brotzka-databaselogger';
    }
}