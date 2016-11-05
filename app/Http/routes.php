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
Route::get('admin', 'AdminController@index');
Route::get('viewmessage/{id}', 'AdminController@viewmessage');
Route::get('panel', 'PanelController@index')->middleware('auth');
Route::get('panel/suggestions', 'SuggestionsController@view')->middleware('auth');
Route::get('panel/suggestions/edit/{id}', 'SuggestionsController@edit')->middleware('auth');
Route::get('panel/news', 'NewsController@view')->middleware('auth');
Route::get('panel/news/add', 'NewsController@add')->middleware('auth');
Route::get('panel/news/edit/{id}', 'NewsController@edit')->middleware('auth');
Route::get('panel/events', 'EventsController@view')->middleware('auth');
Route::get('panel/events/add', 'EventsController@add')->middleware('auth');
Route::get('panel/events/edit/{id}', 'EventsController@edit')->middleware('auth');
Route::get('panel/subscriptions', 'MailingController@view')->middleware('auth');
Route::get('panel/sendmail', 'MailingController@send')->middleware('auth');
Route::get('panel/messages', 'MessagesController@view')->middleware('auth');
Route::get('unsubscribe/{id}', 'MailingController@unsubscribe');
Route::get('talks/view/{id}', 'TalksController@view');
Route::get('talks/all', 'TalksController@viewall');
Route::get('register', 'Auth\AuthController@registration');
Route::get('myaccount', 'PagesController@myaccount')->middleware('auth');
/** POST requests **/
Route::post('contact', 'PagesController@sendMessage');
Route::post('signup', 'MailingController@subscription');
Route::post('sig', 'SuggestionsController@postSuggestion');
Route::post('suggestions/delete/{id}', 'SuggestionsController@delete');
Route::post('news/delete/{id}', 'NewsController@delete');
Route::post('news', 'NewsController@create');
Route::post('events/delete/{id}', 'EventsController@delete');
Route::post('events', 'EventsController@create');
Route::post('sendmail', 'MailingController@sendMail');
Route::post('unsubscribe/{id}', 'MailingController@removeSubscription');
Route::post('unsubscribe', 'MailingController@keepSubscription');
/** PATCH requests **/
Route::patch('suggestions/update/{id}', 'SuggestionsController@update');
Route::patch('/news/update/{id}', 'NewsController@update');
Route::patch('/events/update/{id}', 'EventsController@update');


/** GET|HEAD|POST|PUT|PATCH|DELETE requests **/
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::auth();

// temporal workaround so that registering is not available
//Route::get('register', 'PagesController@index');
