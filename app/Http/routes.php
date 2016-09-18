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
Route::get('admin', 'AdminController@index')->middleware('auth');
Route::get('suggestions', 'SuggestionsController@view')->middleware('auth');
Route::get('suggestions/edit/{id}', 'SuggestionsController@edit')->middleware('auth');
Route::get('subscriptions', 'MailingController@view')->middleware('auth');
Route::get('sendmail', 'MailingController@send')->middleware('auth');
Route::get('messages', 'MessagesController@view')->middleware('auth');

/** POST requests **/
Route::post('contact', 'PagesController@sendMessage');
Route::post('signup', 'MailingController@subscription');
Route::post('sig', 'SuggestionsController@postSuggestion');
Route::post('suggestions/delete/{id}', 'SuggestionsController@delete');
Route::post('sendmail', 'MailingController@sendMail');
/** PATCH requests **/
Route::patch('suggestions/update/{id}', 'SuggestionsController@update');


/** GET|HEAD|POST|PUT|PATCH|DELETE requests **/
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::auth();

// temporal workaround so that registering is not available
Route::get('register', 'PagesController@index');
