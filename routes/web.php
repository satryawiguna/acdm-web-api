<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'WelcomeController@actionWelcome');

Route::post('/register/{group}', 'Auth/RegisterController@actionRegister');

Auth::routes([
    'register' => false,
    'reset' => false
]);

Route::get('/home', 'HomeController@index');
