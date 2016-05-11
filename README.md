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