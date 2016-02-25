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
Route::get('/', 'HomePageController@index');

Route::get('events', 'EventController@browse');


Route::post('events/filter', 'EventController@filter');
Route::get('events/past', 'EventController@browsePast');
Route::get('events/create','EventController@create');
Route::post('events/create', 
  ['as' => 'create_store', 'uses' => 'EventController@store']);
Route::get('events/manage', 'EventController@manageEvents');
Route::post('events/{id}/ticket/confirm', 'TicketController@confirm');
// Route::post('events/{id}/ticket/confirm', function () {
//     return redirect()->route('order');
// });
//Route::get('events/{id}/ticket/confirm/order', ['as' => 'order', 'uses' => 'TicketController@store']);
Route::post('events/{id}/ticket/confirm/order', ['as' => 'order-post', 'uses' => 'TicketController@postOrder']);

Route::get('events/{id}/ticket', 'TicketController@show');


Route::get('events/{id}','EventController@show');
Route::post('events/{id}', 
	['as' => 'contact_attendees', 'uses' => 'EventController@sendMessage']);

Route::get('organisation/create', 'OrganisationController@create');
Route::get('organisation/dashboard', 'OrganisationController@dashboard');
Route::get('organisation', 'OrganisationController@index');
Route::post('organisation', 'OrganisationController@store');
Route::get('organisation/{id}', 'OrganisationController@show');
Route::post('organisation/{id}/favourite', 'OrganisationController@favourite');
Route::post('organisation/{id}', 
	['as' => 'contact_followers', 'uses' => 'OrganisationController@contactFollowers']);
Route::get('organisation/favourite', 'OrganisationController@myFavourites');


Route::get('tickets',['as' => 'display', 'uses' => 'TicketController@index']);
Route::post('tickets', 
	['as' => 'store_tickets', 'uses' => 'TicketController@store']);
Route::get('tickets/{id}', 'TicketController@show');

Route::post('tickets/{id}/cancel', 'TicketController@confirmCancelation');
Route::delete('tickets/{id}', 
 	['as' => 'cancel_order', 'uses' => 'TicketController@destroy']);

Route::get('contact', 
  ['as' => 'contact', 'uses' => 'AboutController@create']);
Route::post('contact', 
  ['as' => 'contact_store', 'uses' => 'AboutController@store']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

