<?php
/**
 * Created by PhpStorm.
 * User: Fabian
 * Date: 10.05.16
 * Time: 06:42
 */

namespace Brotzka\Databaselogger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Logcomment extends model
{
    protected $table = 'brotzka_databaselogger_logcomments';
    
    protected $fillable = [
        'log_id',
        'user_id',
        'title',
        'text'
    ];

    public function log(){
        return $this->belongsTo('Brotzka\Databaselogger\Models\Log');
    }
}