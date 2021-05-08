<?php

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

Route::get('/', 'EventController@index')->name('event.index');
Route::post('/getEvents', 'EventController@getEvents')->name('event.get.list');
Route::post('/sendnotification', 'EventController@sendNotification')->name('event.send.notification');