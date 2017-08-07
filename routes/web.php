<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@new');
Route::post('/', 'HomeController@newHandle');

Route::get('/metrix', 'MetrixController@new');

Route::get('/{id}', 'ReadController@read');
Route::post('/{id}', 'ReadController@readHandle');