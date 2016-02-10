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
use Carbon\Carbon;

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

	//not currently used
	public function index()
	{
		return view('events.browse');
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
		$start_date = new Carbon($request->start_date);
		$end_date = new Carbon($request->end_date);
		//$carbonStart = $carbon->createFromFormat('d-m-Y', $start_date)->toDateString();
		//$carbonEnd = $carbon->createFromFormat('d-m-Y', $end_date)->toDateString();

		$newEvent = EventDetail::create([
						'name'=>$request->name,
						'bio'=>$request->bio,
						'image'=>$request->image,
						'start_date'=>$start_date->toDateTimeString(),
						'end_date'=>$end_date->toDateTimeString(),
						'Location'=>$request->location,
						'no_tickets'=>$request->no_tickets,
						'avail_tickets'=>$request->no_tickets,
						'price'=>$request->price, 
						'genre'=>$request->genre,
					//	'keywords/tags'=>$request->keywords_tags,
					//	'active'=>$request->active, 
						'scope'=>$request->scope
						]);
		
		$eventID = EventDetail::max('id');

		$newOrganise = Organise::create(['event_id'=>$eventID, 'organisation_id'=>$request->organisation]);

		return redirect('events/'.$eventID)->with('message', 'Event Created!');
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
		//needs users filters and scope filters and some kind of algorithm
		//needs to be relevant events not just all.
		$events = EventDetail::all();
		return view('events.browse',compact('events'));	

	}
	public function show($id){

		$event = EventDetail::findOrFail($id);
		//return $eventDetails;
		return view('events.event')->with('event',$event);
	}
	

}
