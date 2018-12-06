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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
/**
 * Threads resource routes.
 */
Route::get('threads', 'ThreadsController@index');
Route::get('threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::post('threads', 'ThreadsController@store');
Route::get('threads/{channel}', 'ThreadsController@index');

/**
 * Reply resource routes.
 */
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::delete("/replies/{reply}", 'RepliesController@destroy');
Route::patch("/replies/{reply}", 'RepliesController@update');

/**
 * favorites resource routes.
 */
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

/**
 * profile related routes.
 */
//Route::get('/profiles/{user}', 'ProfilesController@show');
Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');


Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index');

/**
 * 
 * Thread subcriptions route.
 */

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubcriptionController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubcriptionController@destroy')->middleware('auth');