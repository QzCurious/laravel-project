<?php

use App\Http\Controllers\Auth\OauthLoginController;
use Spatie\Permission\Middlewares\PermissionMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// OAuth login
Route::prefix('oauth/{provider}')->group(function () {
    Route::get('login', [OauthLoginController::class, 'redirectToProvider'])->name('oauth.login');
    Route::get('callback', [OauthLoginController::class, 'handleProviderCallback'])->name('oauth.callback');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('items', 'ItemController');

// Admin
Route::middleware(['auth', PermissionMiddleware::class.':view admin panel'])
    ->prefix(config('authflow.admin_url'))
    ->name('admin.')
    ->group(function () {
        Route::view('/', 'admin.dashboard')->name('dashboard');
        Route::resource('users', 'UserController');
    });
