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


Route::get('login', 'Auth\LoginController@login')->name('login');
Route::post('login', 'Auth\LoginController@attemptLogin');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::any('ajax', 'LegacyController@ajax')->name('ajax')->middleware('auth');;
Route::any('{path}', 'LegacyController@handle')->where('path', '.*')->name('legacy')->middleware('auth');;
