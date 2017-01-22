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

/** GET|HEAD requests * */
Route::get('/', 'PagesController@index');
Route::get('sig', 'SigsController@index');
Route::get('sig/map', 'SigsController@map');
Route::get('sig/{slug}', 'SigsController@sigPage');
Route::get('sig/{slug}/{page}', 'SigsController@sigPage');
Route::get('srv', 'SrvsController@index');
Route::get('talks', 'TalksController@index');
Route::get('contact', 'PagesController@contact');
Route::get('admin', 'AdminController@index');
Route::get('viewmessage/{id}', 'AdminController@viewmessage');
Route::get('unsubscribe/{id}', 'MailingController@unsubscribe');
Route::get('talks/view/{id}', 'TalksController@view');
Route::get('talks/all', 'TalksController@viewall');
Route::get('register', 'Auth\AuthController@registration');
Route::get('api/institutions', 'InstitutionsController@getAllJson');
Route::get('api/sigs', 'SigsController@getAllJson');
Route::get('api/sigs/{id}', 'SigsController@getSigInstitutionsJson');
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
Route::get('myaccount', 'PagesController@myaccount')->middleware('auth');
Route::get('myaccount/personal', 'PagesController@personalDetails')->middleware('auth');
Route::get('myaccount/academic', 'PagesController@academicDetails')->middleware('auth');
Route::get('myaccount/password', 'PagesController@changepassword')->middleware('auth');
Route::get('myaccount/preferences', 'PagesController@preferences')->middleware('auth');
Route::get('panel/tags/add', 'TagsController@add')->middleware('auth');
Route::get('panel/tags/{show?}', 'TagsController@view')->middleware('auth');
Route::get('panel/tags/edit/{id}', 'TagsController@edit')->middleware('auth');
Route::get('panel/institutions', 'InstitutionsController@view')->middleware('auth');
Route::get('panel/institutions/add', 'InstitutionsController@add')->middleware('auth');
Route::get('panel/institutions/edit/{id}', 'InstitutionsController@edit')->middleware('auth');
Route::get('panel/titles', 'TitlesController@view')->middleware('auth');
Route::get('panel/titles/add', 'TitlesController@add')->middleware('auth');
Route::get('panel/titles/edit/{id}', 'TitlesController@edit')->middleware('auth');
Route::get('panel/users', 'UsersController@view')->middleware('auth');
Route::get('panel/users/add', 'UsersController@add')->middleware('auth');
Route::get('panel/users/edit/{id}', 'UsersController@edit')->middleware('auth');
Route::get('panel/sig', 'SigsController@view')->middleware('auth');
Route::get('panel/sig/add', 'SigsController@add')->middleware('auth');
Route::get('panel/sig/edit/{id}', 'SigsController@edit')->middleware('auth');
/** POST requests * */
Route::post('contact', 'PagesController@sendMessage');
Route::post('signup', 'MailingController@subscription');
Route::post('sig', 'SuggestionsController@postSuggestion');
Route::post('suggestions/delete/{id}', 'SuggestionsController@delete')->middleware('auth');
Route::post('news/delete/{id}', 'NewsController@delete')->middleware('auth');
Route::post('news', 'NewsController@create')->middleware('auth');
Route::post('events/delete/{id}', 'EventsController@delete')->middleware('auth');
Route::post('events', 'EventsController@create')->middleware('auth');
Route::post('sendmail', 'MailingController@sendMail')->middleware('auth');
Route::post('unsubscribe/{id}', 'MailingController@removeSubscription');
Route::post('unsubscribe', 'MailingController@keepSubscription');
Route::post('myaccount/personal', 'PagesController@updatePersonalDetails')->middleware('auth');
Route::post('myaccount/academic', 'PagesController@updateAcademicDetails')->middleware('auth');
Route::post('myaccount/password', 'PagesController@updatePassword')->middleware('auth');
Route::post('myaccount/preferences', 'PagesController@updatePreferences')->middleware('auth');
Route::post('tags/delete/{id}', 'TagsController@delete')->middleware('auth');
Route::post('tags/add', 'TagsController@create')->middleware('auth');
Route::post('institutions/delete/{id}', 'InstitutionsController@delete')->middleware('auth');
Route::post('institutions/add', 'InstitutionsController@create')->middleware('auth');
Route::post('titles/delete/{id}', 'TitlesController@delete')->middleware('auth');
Route::post('titles/add', 'TitlesController@create')->middleware('auth');
Route::post('users/delete/{id}', 'UsersController@delete')->middleware('auth');
Route::post('users/add', 'UsersController@create')->middleware('auth');
Route::post('sig/delete/{id}', 'SigsController@delete')->middleware('auth');
Route::post('sig/add', 'SigsController@create')->middleware('auth');
/** PATCH requests * */
Route::patch('suggestions/update/{id}', 'SuggestionsController@update')->middleware('auth');
Route::patch('/news/update/{id}', 'NewsController@update')->middleware('auth');
Route::patch('/events/update/{id}', 'EventsController@update')->middleware('auth');
Route::patch('/tags/update/{id}', 'TagsController@update')->middleware('auth');
Route::patch('/institutions/update/{id}', 'InstitutionsController@update')->middleware('auth');
Route::patch('/titles/update/{id}', 'TitlesController@update')->middleware('auth');
Route::patch('/users/update/{id}', 'UsersController@update')->middleware('auth');
Route::patch('/sig/update/{id}', 'SigsController@update')->middleware('auth');

/** GET|HEAD|POST|PUT|PATCH|DELETE requests * */
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::auth();
