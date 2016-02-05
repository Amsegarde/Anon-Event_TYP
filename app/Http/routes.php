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
Route::get('contact', 'ContactPageController@index');
Route::get('/', 'HomePageController@index');

Route::get('events/browse', 'EventController@browse');
Route::get('events/browsePast', 'EventController@browsePast');
Route::get('events/create', 'EventController@create');
Route::get('events/dashboard', 'EventController@dashboard');
Route::get('events', 'EventController@index');

Route::get('organisation/create', 'OrganisationController@create');
Route::get('organisation/dashboard', 'OrganisationController@dashboard');
Route::get('organisation', 'OrganisationController@index');
Route::post('organisation', 'OrganisationController@store');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
