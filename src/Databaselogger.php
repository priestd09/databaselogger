<?php
/**
 * Created by PhpStorm.
 * User: Fabian
 * Date: 08.05.16
 * Time: 07:20
 */

namespace Brotzka\Databaselogger;

use Brotzka\Databaselogger\Models\Log;
use Mail;

class Databaselogger {

    /*
    |--------------------------------------------------------------------------
    | Some Settings
    |
    */
    /**
     * Returns all available log-levels.
     * 
     * @return array
     */
    public static function getLevels(){
        return Log::getLevels();
    }

    /*
    |--------------------------------------------------------------------------
    | Collect Logs
    |
    */
    /**
     * Returns one log (trashed or not)
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public static function getOneLog($id){
        return Log::withTrashed()->where('id', $id)->first();
    }

    /**
     * Returns the comments to a (trashed) log
     *
     * @param $id
     * @return mixed
     */
    public static function getLogComments($id){
        return Log::withTrashed()->where('id', $id)->first()->logcomment()->get();
    }

    /**
     * Returns all Logs (of a given level)
     * 
     * @param null $level
     * @return bool|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAllLogs($level = NULL){
        if($level === NULL){
            return Log::all();
        } else {
            try {
                return Log::where('level', $level)->get();
            } catch(ModelNotFoundException $e){
                return false;
            }
        }
    }

    /**
     * Returns all unread Logs (of a given level).
     * 
     * @param null $level
     * @return bool
     */
    public static function getUnreadLogs($level = NULL){
        if($level === NULL){
            return Log::where("read", 0)->get();
        } else {
            try {
                return Log::where(['level'=> $level, 'read' => 0])->get();
            } catch(ModelNotFoundException $e){
                return false;
            }
        }
    }

    /**
     * Returns all read Logs (of a given level)
     *
     * @param null $level
     * @return bool
     */
    public static function getReadLogs($level = NULL){
        if($level === NULL){
            return Log::where("read", 1)->get();
        } else {
            try {
                return Log::where(['level'=> $level, 'read' => 1])->get();
            } catch(ModelNotFoundException $e){
                return false;
            }
        }
    }

    /**
     * Returns all unfixed Logs (of a given level)
     *
     * @param null $level
     * @return bool
     */
    public static function getUnfixedLogs($level = NULL){
        if($level === NULL){
            return Log::where("fixed", 0)->get();
        } else {
            try {
                return Log::where(['level'=> $level, 'fixed' => 0])->get();
            } catch(ModelNotFoundException $e){
                return false;
            }
        }
    }

    /**
     * Returns all fixed Logs (of a given level)
     *
     * @param $level
     * @return bool
     */
    public static function getFixedLogs($level = NULL){
        if($level === NULL){
            return Log::where("fixed", 1)->get();
        } else {
            try {
                return Log::where(['level'=> $level, 'fixed' => 1])->get();
            } catch(ModelNotFoundException $e){
                return false;
            }
        }
    }

    /**
     * Returns all trahed Logs (of a given level)
     *
     * @param null $level
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getTrashedLogs($level = NULL){
        if($level === NULL){
            return Log::onlyTrashed()->get();
        } else {
            return Log::onlyTrashed()->where('level', $level)->get();
        }
    }


    /*
    |--------------------------------------------------------------------------
    |
    | Update logs
    |
    */
    /**
     * Mark one or more Logs as read.
     * Takes a single id or an array of ids.
     * 
     * @param null $id
     */
    public static function markAsRead($id = NULL){
        if($id !== NULL){
            if(is_array($id)){
                foreach($id as $one){
                    $log = Log::find($one);
                    $log->read = 1;
                    $log->save();
                }
            } else {
                $log = Log::find($id);
                $log->read = 1;
                $log->save();
            }
        }
    }

    /**
     * Mark one or more Logs as unread.
     * Takes a single id or an array of ids.
     * 
     * @param null $id
     */
    public static function markAsUnread($id = NULL){
        if($id !== NULL){
            if(is_array($id)){
                foreach($id as $one){
                    $log = Log::find($one);
                    $log->read = 0;
                    $log->save();
                }
            } else {
                $log = Log::find($id);
                $log->read = 0;
                $log->save();
            }
        }
    }

    /**
     * Mark one or more Logs as fixed.
     * Takes a single id or an array of ids.
     * 
     * @param null $id
     */
    public static function markAsFixed($id = NULL){
        if($id !== NULL){
            if(is_array($id)){
                foreach($id as $one){
                    $log = Log::find($one);
                    $log->fixed = 1;
                    $log->save();
                }
            } else {
                $log = Log::find($id);
                $log->fixed = 1;
                $log->save();
            }
        }
    }

    /**
     * Mark one or more Logs as unfixed.
     * Takes a single id or an array of ids.
     * 
     * @param null $id
     */
    public static function markAsUnfixed($id = NULL){
        if($id !== NULL){
            if(is_array($id)){
                foreach($id as $one){
                    $log = Log::find($one);
                    $log->fixed = 0;
                    $log->save();
                }
            } else {
                $log = Log::find($id);
                $log->fixed = 0;
                $log->save();
            }
        }
    }



    /*
    |--------------------------------------------------------------------------
    |
    | Delete or restore logs
    |
    */
    /**
     * Deletes one or more logs
     * 
     * @param null $id
     */
    public static function moveToTrash($id = NULL){
        if($id !== NULL){
            if(is_array($id)){
                foreach($id as $one){
                    $log = Log::find($id);
                    $log->delete();
                }
            } else {
                $log = Log::find($id);
                $log->delete();
            }
        }
    }

    /**
     * Drops all trashed Logs from the database
     * 
     * @return bool
     */
    public static function emptyTrash(){
        try {
            $deletedLogs = Log::onlyTrashed()->get();
            $deletedLogs->forceDelete();
            return true;
        } catch(ModelNotFoundException $e){
            return false;
        }

    }

    /**
     * Restore one or more logs
     * 
     * @param null $id
     */
    public static function restoreLog($id = NULL){
        if($id !== NULL){
            if(is_array($id)){
                foreach($id as $one){
                    $log = Log::withTrashed()->where('id', $one)->first();
                    $log->restore();
                }
            } else {
                $log = Log::withTrashed()->where('id', $id)->first();
                $log->restore();
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Mail-Handler
    |--------------------------------------------------------------------------
    |
    | This Method sends the Mails
    |
    */
    private static function sendMail(Log $log){
        if(config('databaselogger.' . $log->level . 'Mail')){
            $data = [
                'log'   => $log,
                'url'   => url('/'),
            ];

            Mail::send('brotzka-databaselogger::mail', $data, function ($m) use($log) {
                $m->from(
                    config("databaselogger.mailFrom"),
                    config("databaselogger.mailFromName")
                );

                $m->to(
                    config("databaselogger.mailTo"),
                    config("databaselogger.mailToName"))->subject(config("databaselogger.emergencySubject " . $log->title)
                );
            });
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Error-Handling
    |--------------------------------------------------------------------------
    |
    | The following methods handle the error-reporting for each level
    |
    */
    /**
     * @param $error
     * @return Log
     */
    public static function emergency($errMessage, $errTitle){
        $log = new Log([
            'level' => 'emergency',
            'title' => $errTitle,
            'message'   => $errMessage
        ]);
        $log->save();
        self::sendMail($log);
        return $log;
    }

    /**
     * @param $error
     * @return Log
     */
    public static function alert($errMessage, $errTitle){
        $log = new Log([
            'level' => 'alert',
            'title' => $errTitle,
            'message'   => $errMessage
        ]);
        $log->save();
        self::sendMail($log);
        return $log;
    }

    /**
     * @param $error
     * @return Log
     */
    public static function critical($errMessage, $errTitle){
        $log = new Log([
            'level' => 'critical',
            'title' => $errTitle,
            'message'   => $errMessage
        ]);
        $log->save();
        self::sendMail($log);
        return $log;
    }

    /**
     * @param $error
     * @return Log
     */
    public static function error($errMessage, $errTitle){
        $log = new Log([
            'level' => 'error',
            'title' => $errTitle,
            'message'   => $errMessage
        ]);
        $log->save();
        self::sendMail($log);
        return $log;
    }

    /**
     * @param $error
     * @return Log
     */
    public static function warning($errMessage, $errTitle){
        $log = new Log([
            'level' => 'warning',
            'title' => $errTitle,
            'message'   => $errMessage
        ]);
        $log->save();
        self::sendMail($log);
        return $log;
    }

    /**
     * @param $error
     * @return Log
     */
    public static function notice($errMessage, $errTitle){
        $log = new Log([
            'level' => 'notice',
            'title' => $errTitle,
            'message'   => $errMessage
        ]);
        $log->save();
        self::sendMail($log);
        return $log;
    }

    /**
     * @param $error
     * @return Log
     */
    public static function info($errMessage, $errTitle){
        $log = new Log([
            'level' => 'emergency',
            'title' => $errTitle,
            'message'   => $errMessage
        ]);
        $log->save();
        self::sendMail($log);
        return $log;
    }

    /**
     * @param $error
     * @return Log
     */
    public static function debug($errMessage, $errTitle){
        $log = new Log([
            'level' => 'debug',
            'title' => $errTitle,
            'message'   => $errMessage
        ]);
        $log->save();
        self::sendMail($log);
        return $log;
    }
}