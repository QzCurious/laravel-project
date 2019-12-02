# Laravel ECommerce

## Environment

-   php
    -   pdo_mysql
-   composer
-   mariadb
-   nodejs
-   npm

## Install Laravel

1. `composer create-project laravel/laravel .`
2. `composer require laravel/ui --dev`
3. (mysql) `create database ECommerce;`
4. Setup _.env_ for database
5. `php artisan migrate`
6. `php artisan ui bootstrap --auth`
7. `npm install && npm run dev`

## Troubleshooting

### `php artisan make:auth`: Command "make:auth" is not defined

Laravel 6 separates authentication to a dedicate package **laravel/ui**.
Install **laravel/ui** and run `php artisan ui:auth` instead.

### `php artisan migrate`: could not find driver

Install and configure extension **pdo_mysql** for php.

## Problems

-   Not sure if we should version control compiled css and js files,
    that is, files in _public/css_ and _public/js_
