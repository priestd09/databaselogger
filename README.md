# A Laravel Databaselogger

## Description

This package is made to save your logs in your database instead of a file.

## Functions

- Save your logs to a database
- Create your own logs for different levels
  - emergency
  - alert
  - critical
  - error
  - warning
  - notice
  - info
  - debug
- Set emailnotification for each level
- Comment logs (under construction)

## Installation

The package is made for Laravel 5.*.

First add `"brotzka/databaselogger": "dev-master"` to your composer.json in the `require-dev`-section:

    "require-dev": {
        ...
        "brotzka/databaselogger": "dev-master"
    }

Then run `composer update` to install the package.

Now you have to add service providers and aliases. Open `config/app.php` and scroll down to the `providers`-array and add the following line:


    Brotzka\Databaselogger\DatabaseloggerServiceProvider::class,

Now scroll down to the `aliases`-array and add the following line at the end:

    'Databaselogger' => Brotzka\Databaselogger\DatabaseloggerFacade::class,

Now you have to publish the config, migration and view, so run this command:

    php artisan vendor:publish

If it doesn't work, try this:

    php artisan vendor:publish --provider="Brotzka\Databaselogger\DatabaseloggerServiceProvider"

Now you have to migrate the tables:

    php artisan migrate

## Configuration
Now you can configure this package. Open `config/databaselogger` and replace the example values for receiver and sender.
If you want, you can place the four values in your .env:

 - BROTZKADBLOGGER_MAILTO=your_value
 - BROTZKADBLOGGER_MAILTONAME=your_value
 - BROTZKADBLOGGER_MAILFROM=your_value
 - BROTZKADBLOGGER_MAILFROMNAME=your_value

So the config will automatically load the values from there.

## Available Functions

### Helpers

#### getLevels()

Returns all available log-levels

### Collect logs

#### getOneLog($id)
Returns one log, no matter if trashed or not

#### getLogComments($id)
Retrurns all comments of a (trashed) log

#### getAllLogs($level = NULL)
Returns all logs or all logs of a given level

#### getUnreadLogs($level = NULL)
Returns all unread logs (of a given level)

#### getReadLogs($level = NULL)
Returns all read logs (of a given level)

#### getUnfixedLogs($level = NULL)
Returns all unfixed logs (of a given level)

#### getFixedLogs($level = NULL)
Returns all fixed logs (of a given level)

#### getTrashedLogs($level = NULL)
Returns all trashed logs (of a given level)

### Update logs

#### markAsRead($id = NULL)
Mark one or more logs as read. Takes a single id or an array of ids, e.g.:

    // Single log
    Databaselogger::markAsRead(12);

    // Array
    $ids = [2,5,7,9];
    Databaselogger::markAsRead($ids)

#### markAsUnread($id = NULL)
Mark one or more logs as unread. Takes one id or an array of ids.
See `markAsRead()` as example.

#### markAsFixed($id = NULL)
Mark one or more logs as fixed. Takes one id or an array of ids.
See `markAsRead()` as example.

#### markAsUnfixed($id = NULL)
Mark one or more logs as unfixed. Takes one id or an array of ids.
See `markAsRead()` as example.

### Delete / restore logs

#### moveToTrash($id = NULL)
Move one or more logs to trash. Takes one id or an array of ids.
See `markAsRead()` as example.


#### emptyTrash()
Drop all trashed logs from the database. Returns false/true.

#### restoreLog($id = NULL)
Restore one or more logs (only available for trashed logs). Takes on id or an array of ids.
See `markAsRead()` as example.


### Create logs

#### ?level($errMessage, $errTitle)
`?level` must be replaced with one of the following levels.

 - emergency
 - alert
 - critical
 - error
 - warning
 - notice
 - info
 - debug