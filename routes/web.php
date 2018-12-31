<?php

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
// })->middleware('auth');

Route::get('login', 'Auth\LoginController@login');
Route::post('login', 'Auth\LoginController@attemptLogin');

// Route::get('{path}', 'LegacyController@handle')->where('path', '.*')->name('legacy')->middleware('auth');;
