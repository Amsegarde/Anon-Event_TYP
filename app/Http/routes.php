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
Route::get('about', 'AboutController@index');
Route::get('about/contact', 'AboutController@create');
Route::get('/', 'HomePageController@index');

Route::post('media', 'EventController@media');
Route::get('events', 'EventController@browse');
Route::post('events', 'EventController@browse');
Route::get('events/past', 'EventController@browsePast');
Route::post('events/past', 'EventController@browsePast');
Route::get('events/create','EventController@create');
Route::post('events/create', 
  ['as' => 'create_store', 'uses' => 'EventController@store']);
// Route::post('events/create',
// 	['as' => 'create_org', 'uses' => 'OrganisationController@store']);
Route::get('events/manage', 'EventController@manageEvents');
Route::post('events/{id}/ticket/confirm', 'TicketController@confirmPage');
// Route::post('events/{id}/ticket/confirm', function () {
//     return redirect()->route('order');
// });
//Route::get('events/{id}/ticket/confirm/order', ['as' => 'order', 'uses' => 'TicketController@store']);
Route::post('events/{id}/ticket/confirm/order', ['as' => 'order-post', 'uses' => 'TicketController@postOrder']);

Route::get('events/{id}/ticket', 'TicketController@show');
Route::get('events/{id}/delete', 'EventController@delete');
Route::delete('events/{id}/delete/confirm', [
	'as' => 'cancel_event', 'uses' => 'EventController@destroy']);


Route::get('events/{id}','EventController@show');
Route::post('events/{id}', 
	['as' => 'contact_attendees', 'uses' => 'EventController@sendMessage']);

Route::get('events/{id}/badges', 'EventController@printBadges');


Route::post('vote','EventController@vote');
Route::post('date_vote','EventController@date_vote');

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

Route::get('ticket/{id}/print', 
	['as' => 'ticket_print', 'uses' => 'TicketController@helloWorld']);

Route::post('ticket/{id}/contact', 
	['as' => 'contact_organisation', 'uses' => 'OrganisationController@contact']);

Route::post('tickets/{id}/cancel', 'TicketController@confirmCancelation');
Route::delete('tickets/{id}', 
 	['as' => 'cancel_order', 'uses' => 'TicketController@destroy']);

Route::get('contact', 
  ['as' => 'contact', 'uses' => 'AboutController@create']);
Route::post('contact', 
  ['as' => 'contact_store', 'uses' => 'AboutController@store']);

Route::get('users/account', 'OrganisationController@getAccount');
Route::get('users/{id}/account', 'OrganisationController@account');
Route::post('users/{id}/account/update/details', 
 	['as' => 'update_details', 'uses' => 'OrganisationController@updateAccountDetails']);
Route::post('users/{id}/account/update/email', 
 	['as' => 'update_email', 'uses' => 'OrganisationController@updateAccountEmail']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);




