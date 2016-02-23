<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Event;

use Illuminate\Http\Request;

class HomePageController extends Controller {

	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$event = Event::all();
		return view('home', array('events'=>$event));
		//return view('welcome');
	}
	public function test()
	{
		return "hello";
		//return view('welcome');
	}

}
