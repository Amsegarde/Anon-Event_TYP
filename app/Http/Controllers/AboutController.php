<?php namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Mail;


class AboutController extends Controller {


	public function create()
    {
        return view('about.contact');
    }

    public function store(ContactFormRequest $request)
    {
	    Mail::send('emails.contact',
	       array(
	            'name' => $request->get('name'),
	            'email' => $request->get('email'),
	            'user_message' => $request->get('message')
	        ), function($message) use ($request)
	    {
	    	$message->to('anonevent.cs@gmail.com', 'Admin')
       						->from($request->email)
       						->subject('Anon-Event Feedback');
	    });

	  	return \Redirect::route('contact')->with('message', 'Thanks for contacting us!');
    }

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

		return view('welcome');

		//return "hello";
		return view('about');

	}

}
