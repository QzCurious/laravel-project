# Laravel ECommerce

## Environment

-   php
    -   pdo_mysql
-   composer
-   mariadb
-   nodejs
-   npm
-   heroku-cli

## Install Laravel

1. `composer create-project laravel/laravel .`
2. `composer require laravel/ui --dev`
3. (mysql) `create database ECommerce;`
4. Setup _.env_ for database
5. `php artisan migrate`
6. `php artisan ui bootstrap --auth`
7. `npm install && npm run dev`

## Deploy on Heroku

1. `echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile`
2. Push on Heroku
3. `heroku config:set APP_KEY=$(php artisan --no-ansi key:generate --show)`

Reference:

-   [Getting Started with Laravel on Heroku](https://devcenter.heroku.com/articles/getting-started-with-laravel)

## Heroku Cleardb

1. `heroku addons:add cleardb`
2. Get cleardb credential by `heroku config:get CLEARDB_DATABASE_URL`
3. **CLEARDB_DATABASE_URL** is in form of `mysql://username:password@hostname/database_name?reconnect=true`
4. Setup config vars for laravel to access cleardb (copy the credentials and do `heroku config:set DB_CONNECTION=mysql DB_HOST=<host> DB_DATABASE=<DATABASE> DB_USERNAME=<USERNAME> DB_PASSWORD=<PASSWORD>`)
5. `heroku run php artisan migrate`

Reference:

-   [ClearDB MySQL](https://devcenter.heroku.com/articles/cleardb)

## Troubleshooting

### `php artisan make:auth`: Command "make:auth" is not defined

Laravel 6 separates authentication to a dedicate package **laravel/ui**.
Install **laravel/ui** and run `php artisan ui:auth` instead.

### `php artisan migrate`: could not find driver

Install and configure extension **pdo_mysql** for php.

### SQLSTATE: 1071 Specified key was too long

Calling the `Schema::defaultStringLength` method within your `AppServiceProvider@boot`

Reference: https://laravel.com/docs/master/migrations#creating-indexes

## Tips

### Heroku

-   To omit `--app` option for heroku cli commands, add a git remote points to **Heroku Git URL** of the app. [Reference](https://stackoverflow.com/questions/55470675/how-to-avoid-the-app-option-with-heroku-cli)
-   **Config Vars** are equivalent to key-values in _.env_ file.

## Problems

-   Not sure if we should version control compiled css and js files,
    that is, files in _public/css_ and _public/js_
