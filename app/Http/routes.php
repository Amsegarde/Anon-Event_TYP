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

//Route::get('home','HomePageController@test');
Route::get('about', 'AboutPageController@index');

Route::get('browseEvents', 'BrowseEventsController@index');
Route::get('browsePastEvents', 'BrowsePastEventsController@index');
Route::get('contact', 'ContactPageController@index');
Route::get('createEvent', 'CreateEventController@index');
Route::get('createEvent', 'CreateEventController@index');
Route::get('createOrganisation', 'createOrganisationController@index');
Route::get('eventDashboard', 'EventDashboardController@index');
Route::get('events', 'EventPageController@index');
Route::get('/', 'HomePageController@index');
Route::get('organisationDashboard', 'OrganisationDashboardController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
