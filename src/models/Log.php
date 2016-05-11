<?php
/**
 * Created by PhpStorm.
 * User: Fabian
 * Date: 08.05.16
 * Time: 07:35
 */

namespace Brotzka\Databaselogger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mail;

class Log extends Model
{
    // TODO: implement a static attribute which represents the number of Logs (perhaps more than one attribute)

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = "brotzka_databaselogger_logs";

    protected static $levels = [
        'emergency',
        'alert',
        'critical',
        'error',
        'warning',
        'notice',
        'info',
        'debug'
    ];

    protected $fillable = [
        'level',
        'title',
        'message',
        'fixed',
        'read'
    ];

    public function logcomment(){
        return $this->hasMany('Brotzka\Databaselogger\Models\Logcomment', 'log_id');
    }

    public static function getLevels(){
        return self::$levels;
    }
    
    
}