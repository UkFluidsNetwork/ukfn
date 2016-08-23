<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/** GET|HEAD requests **/
Route::get('/', 'PagesController@index');
Route::get('sig', 'SigsController@index');
Route::get('srv', 'SrvsController@index');
Route::get('talks', 'TalksController@index');
Route::get('contact', 'PagesController@contact');

/** POST requests **/
Route::post('contact', 'PagesController@sendMessage');

/** GET|HEAD|POST|PUT|PATCH|DELETE requests **/
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::auth();

