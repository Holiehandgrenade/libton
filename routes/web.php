<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Auth::loginUsingId(1);
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@show');

Route::get('/libs', 'LibsController@index');
Route::post('/libs', 'LibsController@store');
Route::get('/libs/create', 'LibsController@create');
Route::get('/libs/{lib}/edit', 'LibsController@edit');
Route::patch('/libs/{lib}', 'LibsController@update');
Route::get('/libs/{lib}', 'LibsController@show');
Route::delete('/libs/{lib}', 'LibsController@destroy');
Route::get('libs/{lib}/play', 'LibsController@play');