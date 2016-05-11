<?php
/**
 * Created by PhpStorm.
 * User: Fabian
 * Date: 08.05.16
 * Time: 07:32
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Mail information
    |--------------------------------------------------------------------------
    |
    | Change the following details so they fit for your application
    |
    */
    'mailTo'        => env('BROTZKADBLOGGER_MAILTO', 'example@domain.net'),
    'mailToName'    => env('BROTZKADBLOGGER_MAILTONAME','Systemadmin'),
    'mailFrom'      => env('BROTZKADBLOGGER_MAILFROM', 'server@domain.net'),
    'mailFromName'  => env('BROTZKADBLOGGER_MAILFROMNAME', 'Server'),


    /*
    |--------------------------------------------------------------------------
    | Mail config
    |--------------------------------------------------------------------------
    |
    | All levels with a 1 send an email if one of this errors occure.
    | You can define a custom subject-text if you want.
    |
    */
    'emergencyMail'     => 1,
    'emergencySubject'  => "Emergency: ",

    'alertMail'         => 1,
    'alertSubject'      => "Alert: ",

    'criticalMail'      => 1,
    'criticalSubject'   => "Critical: ",

    'errorMail'         => 1,
    'errorSubject'      => "Error: ",

    'warningMail'       => 1,
    'warningSubject'    => "Warning: ",

    'noticeMail'        => 1,
    'noticeSubject'     => "Notice: ",

    'infoMail'          => 1,
    'infoSubject'       => "Info: ",

    'debugMail'         => 1,
    'debugSubject'      => "Debug: "
];