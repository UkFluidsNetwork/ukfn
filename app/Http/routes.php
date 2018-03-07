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
// public
Route::get('/', 'PagesController@index');
Route::get('sig', 'SigsController@map');
Route::get('sig/second-call', 'SigsController@results');
Route::get('sig/calendar', 'SigsController@calendar');
Route::get('sig/{slug}', 'SigsController@sigPage');
Route::get('sig/{slug}/{page}', 'SigsController@sigPage');
Route::get('srv', 'SrvsController@index');
Route::get('researcher-resources', 'ResourcesController@index');
Route::get('talks', 'TalksController@index');
Route::get('talks/stream', 'TalksController@stream');
Route::get('directory', 'PagesController@researchersDirectory');
Route::get('connect', 'PagesController@about');
Route::get('about', function() {return Redirect::to('connect');}); // old URI
Route::get('contact', function() {return Redirect::to('connect');}); // old URI
Route::get('admin', function() {return Redirect::to('connect');}); // old URI
Route::get('competition', 'CompetitionController@index');
Route::get('competition/vote/{type}', 'CompetitionController@displayEntries');
Route::get('competition/winner/{type}', 'CompetitionController@displayWinners');
Route::get('viewmessage/{id}', 'PagesController@viewmessage');
Route::get('talks/{id}', 'TalksController@view');
Route::get('register', 'Auth\AuthController@registration');
Route::get('api/institutions', 'InstitutionsController@getAllJson');
Route::get('api/sigs', 'SigsController@getAllJson');
Route::get('api/talks/{query}', 'TalksController@getAllJson');
Route::get('api/resources/', 'ResourcesController@getAllJson');
Route::get('api/sigs/{id}', 'SigsController@getSigInstitutionsJson');
Route::get('api/tags/{tagtype}', 'TagsController@getAllJson');
Route::get('api/tags/{tagtype}/categories', 'TagsController@getAllCategoriesJson');
Route::get('api/public/users/', 'UsersController@getUsersPublicJson');
// require login
Route::get('myaccount', 'PagesController@myaccount')->middleware('auth');
Route::get('myaccount/personal', 'PagesController@personalDetails')->middleware('auth');
Route::get('myaccount/academic', 'PagesController@academicDetails')->middleware('auth');
Route::get('myaccount/password', 'PagesController@changepassword')->middleware('auth');
Route::get('myaccount/preferences', 'PagesController@preferences')->middleware('auth');
// require canEditSig
Route::get('panel/sig/edit/{id}', 'SigsController@edit')->middleware('sig');
Route::get('panel/sig/members/{id}', 'SigsController@members')->middleware('sig');
Route::get('panel/sig/files/{id}', 'SigsController@listFiles')->middleware('sig');
Route::get('panel/sig/files/add/{id}', 'SigsController@addFile')->middleware('sig');
Route::get('panel/sig/box/{id}', 'SigsController@listBoxes')->middleware('sig');
Route::get('panel/sig/box/add/{id}', 'SigsController@addBox')->middleware('sig');
Route::get('panel/sig/box/edit/{id}', 'SigsController@editBox')->middleware('sig-box');
Route::get('panel/sig/box/toggle/{id}', 'SigsController@toggleBoxStatus')->middleware('sig-box');
Route::get('panel/sig/box/move/{direction}/{id}', 'SigsController@moveBox')->middleware('sig-box');

Route::get('api/sig/members/{id}', 'SigsController@getSigMembersJson')->middleware('sig');
// require canViewUsers
Route::get('api/users/{id}', 'UsersController@getUserJson')->middleware('admin-leader');
// require admin
Route::get('panel', 'PanelController@index')->middleware('admin');
Route::get('panel/suggestions', 'SuggestionsController@view')->middleware('admin');
Route::get('panel/suggestions/edit/{id}', 'SuggestionsController@edit')->middleware('admin');
Route::get('panel/news', 'NewsController@view')->middleware('admin');
Route::get('panel/news/add', 'NewsController@add')->middleware('admin');
Route::get('panel/news/edit/{id}', 'NewsController@edit')->middleware('admin');
Route::get('panel/events', 'EventsController@view')->middleware('admin');
Route::get('panel/events/add', 'EventsController@add')->middleware('admin');
Route::get('panel/events/edit/{id}', 'EventsController@edit')->middleware('admin');
Route::get('panel/sendmail', 'MailingController@send')->middleware('admin');
Route::get('panel/messages', 'MessagesController@view')->middleware('admin');
Route::get('panel/tags/add', 'TagsController@add')->middleware('admin');
Route::get('panel/tags/{show?}', 'TagsController@view')->middleware('admin');
Route::get('panel/tags/edit/{id}', 'TagsController@edit')->middleware('admin');
Route::get('panel/institutions', 'InstitutionsController@view')->middleware('admin');
Route::get('panel/institutions/add', 'InstitutionsController@add')->middleware('admin');
Route::get('panel/institutions/edit/{id}', 'InstitutionsController@edit')->middleware('admin');
Route::get('panel/titles', 'TitlesController@view')->middleware('admin');
Route::get('panel/titles/add', 'TitlesController@add')->middleware('admin');
Route::get('panel/titles/edit/{id}', 'TitlesController@edit')->middleware('admin');
Route::get('panel/users', 'UsersController@view')->middleware('admin');
Route::get('panel/users/export', 'UsersController@export')->middleware('admin');
Route::get('panel/users/add', 'UsersController@add')->middleware('admin');
Route::get('panel/users/edit/{id}', 'UsersController@edit')->middleware('admin');
Route::get('panel/sig', 'SigsController@view')->middleware('admin');
Route::get('panel/sig/add', 'SigsController@add')->middleware('admin');
Route::get('panel/talks/add', 'TalksController@add')->middleware('admin');
Route::get('panel/talks', 'TalksController@talksList')->middleware('admin');
Route::get('panel/talks/edit/{id}', 'TalksController@edit')->middleware('admin');
Route::get('panel/talks/feeds/', 'AggregatorsController@view')->middleware('admin');
Route::get('panel/talks/feeds/add', 'AggregatorsController@add')->middleware('admin');
Route::get('panel/talks/feeds/edit/{id}', 'AggregatorsController@edit')->middleware('admin');
Route::get('panel/files/add', 'FilesController@add')->middleware('admin');
Route::get('panel/files', 'FilesController@index')->middleware('admin');
Route::get('panel/srv', 'SrvsController@view')->middleware('admin');
Route::get('panel/srv/add', 'SrvsController@add')->middleware('admin');
Route::get('panel/srv/edit/{id}', 'SrvsController@edit')->middleware('admin');
Route::get('panel/competition/votes', 'CompetitionController@votes')->middleware('admin');
Route::get('panel/competition/votes/export', 'CompetitionController@export')->middleware('admin');
Route::get('panel/resources', 'ResourcesController@view')->middleware('admin');
Route::get('panel/resources/add', 'ResourcesController@add')->middleware('admin');
Route::get('panel/resources/edit/{id}', 'ResourcesController@edit')->middleware('admin');
Route::get('panel/resources/toggle/{id}', 'ResourcesController@toggleResourceStatus')->middleware('admin');
Route::get('panel/resources/move/{direction}/{id}', 'ResourcesController@moveResource')->middleware('admin');
Route::get('panel/resources/tutorials/{resource_id}', 'ResourcesController@viewTutorials')->middleware('admin');
Route::get('panel/resources/tutorials/add/{resouce_id}', 'ResourcesController@addTutorial')->middleware('admin');
Route::get('panel/resources/tutorials/edit/{id}', 'ResourcesController@editTutorial')->middleware('admin');
Route::get('panel/resources/tutorials/files/{id}', 'ResourcesController@tutorialFiles')->middleware('admin');
Route::get('panel/resources/tutorials/files/add/{id}', 'ResourcesController@addFile')->middleware('admin');
Route::get('panel/resources/tutorials/toggle/{id}', 'ResourcesController@toggleTutorialStatus')->middleware('admin');
Route::get('panel/resources/tutorials/move/{direction}/{id}', 'ResourcesController@moveTutorial')->middleware('admin');
Route::get('panel/files/addlink', 'FilesController@addLink')->middleware('admin');
/** POST requests * */
// public
Route::post('contact', 'PagesController@sendMessage');
Route::post('signup', 'MailingController@subscription');
Route::post('subscribe-sig', 'MailingController@sigSubscription');
Route::post('sig', 'SuggestionsController@postSuggestion');
Route::post('competition/vote', 'CompetitionController@vote');
// require login
Route::post('myaccount/personal', 'PagesController@updatePersonalDetails')->middleware('auth');
Route::post('myaccount/academic', 'PagesController@updateAcademicDetails')->middleware('auth');
Route::post('myaccount/password', 'PagesController@updatePassword')->middleware('auth');
Route::post('myaccount/preferences', 'PagesController@updatePreferences')->middleware('auth');
Route::post('panel/files/delete/{id}', 'FilesController@delete')->middleware('auth'); //further checks in function
// require canEditSigBox
Route::post('/panel/sig/box/delete/{id}', 'SigsController@deleteBox')->middleware('sig-box');
// require canEditSig
Route::post('/panel/sig/box/add', 'SigsController@createBox')->middleware('sig');
Route::post('sig/members/{action}/{id}', 'SigsController@administerMember')->middleware('sig');
Route::get('api/users/', 'UsersController@getUsersJson')->middleware('admin-leader');
Route::post('panel/sig/files/add/{id}', 'FilesController@create')->middleware('sig');
// require admin
Route::post('suggestions/delete/{id}', 'SuggestionsController@delete')->middleware('admin');
Route::post('news/delete/{id}', 'NewsController@delete')->middleware('admin');
Route::post('news', 'NewsController@create')->middleware('admin');
Route::post('events/delete/{id}', 'EventsController@delete')->middleware('admin');
Route::post('events', 'EventsController@create')->middleware('admin');
Route::post('sendmail', 'MailingController@sendMail')->middleware('admin');
Route::post('mailing/delete/{id}', 'MailingController@deleteSubscription')->middleware('admin');
Route::post('tags/delete/{id}', 'TagsController@delete')->middleware('admin');
Route::post('tags/add', 'TagsController@create')->middleware('admin');
Route::post('institutions/delete/{id}', 'InstitutionsController@delete')->middleware('admin');
Route::post('institutions/add', 'InstitutionsController@create')->middleware('admin');
Route::post('titles/delete/{id}', 'TitlesController@delete')->middleware('admin');
Route::post('titles/add', 'TitlesController@create')->middleware('admin');
Route::post('users/delete/{id}', 'UsersController@delete')->middleware('admin');
Route::post('users/add', 'UsersController@create')->middleware('admin');
Route::post('sig/delete/{id}', 'SigsController@delete')->middleware('admin');
Route::post('sig/add', 'SigsController@create')->middleware('admin');
Route::post('panel/talks/feeds/delete/{id}', 'AggregatorsController@delete')->middleware('admin');
Route::post('panel/talks/feeds/add', 'AggregatorsController@create')->middleware('admin');
Route::post('panel/talks/delete/{id}', 'TalksController@delete')->middleware('admin');
Route::post('panel/talks/add', 'TalksController@create')->middleware('admin');
Route::post('panel/files/add', 'FilesController@create')->middleware('admin');
Route::post('panel/files/addlink', 'FilesController@createLink')->middleware('admin');
Route::post('srv/delete/{id}', 'SrvsController@delete')->middleware('admin');
Route::post('srv/add', 'SrvsController@create')->middleware('admin');
Route::post('resources/delete/{id}', 'ResourcesController@delete')->middleware('admin');
Route::post('resources/add', 'ResourcesController@create')->middleware('admin');
Route::post('resources/tutorials/add', 'ResourcesController@createTutorial')->middleware('admin');
Route::post('resources/tutorials/delete/{id}', 'ResourcesController@deleteTutorial')->middleware('admin');
Route::post('resources/tutorials/files/add/{tutorial_id}', 'ResourcesController@addTutorialFile')->middleware('admin');
Route::post('resources/tutorials/files/delete/{id}', 'ResourcesController@deleteFile')->middleware('admin');
/** PATCH requests * */
// require canEditSigBox
Route::patch('/panel/sig/box/update/{id}', 'SigsController@updateBox')->middleware('sig-box');
// require canEditSig
Route::patch('/sig/update/{id}', 'SigsController@update')->middleware('sig');
// require admin
Route::patch('suggestions/update/{id}', 'SuggestionsController@update')->middleware('admin');
Route::patch('/news/update/{id}', 'NewsController@update')->middleware('admin');
Route::patch('/events/update/{id}', 'EventsController@update')->middleware('admin');
Route::patch('/tags/update/{id}', 'TagsController@update')->middleware('admin');
Route::patch('/institutions/update/{id}', 'InstitutionsController@update')->middleware('admin');
Route::patch('/titles/update/{id}', 'TitlesController@update')->middleware('admin');
Route::patch('/users/update/{id}', 'UsersController@update')->middleware('admin');
Route::patch('/panel/talks/update/{id}', 'TalksController@update')->middleware('admin');
Route::patch('/panel/talks/feeds/update/{id}', 'AggregatorsController@update')->middleware('admin');
Route::patch('/srv/update/{id}', 'SrvsController@update')->middleware('admin');
Route::patch('/resources/update/{id}', 'ResourcesController@update')->middleware('admin');
Route::patch('/resources/tutorials/update/{id}', 'ResourcesController@updateTutorial')->middleware('admin');

/** GET|HEAD|POST|PUT|PATCH|DELETE requests * */
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::auth();
