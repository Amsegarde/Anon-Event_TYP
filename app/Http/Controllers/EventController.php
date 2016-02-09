<?php namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use App\Http\Requests\CreateEventFormRequest;
use App\Http\Controllers\Controller;
use Auth;
use App\Admin;
use App\Organisation;
use DB;
use Illuminate\Http\Request;
use App\EventDetail;
use App\Organise;

class EventController extends Controller {

	//

	/**
	 * Show the event dashboard screen to the user.
	 *
	 * @return Response
	 */
	public function dashboard()
	{
		return view('events.dashboard');
	}

	/**
	 * Show the event details to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('events.event');
	}

	/**
	 * Show the create event to the user.
	 *
	 * @return Response
	 */
	public function create()
	{
		$id = Auth::id();
		$organisations = DB::table('organisations')
								->whereIn('id', function($query) use ($id) {
										$query->select('id')
										->from('admins')
										->where('user_id', '=', '?')
										->setBindings([$id]);
								})->get();
		return view('events.create', compact('organisations'));
	}

	/**
	 * Create a new entry in the events table
	 *
	 * @return Redirect
	 */
	public function store(CreateEventFormRequest $request){
		
		$newEvent = EventDetail::create(['name'=>$request->name,
						'bio'=>$request->bio]
						//'image'=>$request->image,
						//'date'=>$request->date,
						//'Location'=>$request->location, 
					///	'no_tickets'=>$request->no_tickets,
					//	'avail_tickets'=>$request->avail_tickets,
					//	'price'=>$request->price, 
					//	'genre'=>$request->genre,
					//	'keywords/tags'=>$request->keywords_tags,
					//	'active'=>$request->active, 
					//	'scope'=>$request->scope]
						);
		
		$eventID = EventDetail::max('event_id');
		

		$newOrganise = Organise::create(['event_id'=>$eventID, 'organisation_id'=>$request->organisation]);
	//	$newOrganise->event_id = $eventID;
	//	$newOrganise->organisation_id = $request->organisation;
	//	$newOrganise->save();

		return redirect('events')->with('message', 'Event Created!');
		}
	/**
	 * Show the past events list to the user.
	 *
	 * @return Response
	 */
	public function browsePast()
	{
		return view('events.browsePast');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function browse()
	{
		return view('events.browse');	

}

}
