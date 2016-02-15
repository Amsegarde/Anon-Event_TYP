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
use App\Itinerary;
use App\EventContain;
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

		$newOrganise = Organise::create([
							'event_id'=>$eventID, 
							'organisation_id'=>$request->organisation]);
		//added by joe to handle incoming intinery items
		$itins = $request->item;
		//return $itins;
		$size = count($itins);
		for($i = 1; $i< $size; $i+=6){
			if(isset($itins[$i+5])){
				
				$prebooked = 1;
			}
			else{
				$prebooked = 0;
			}
			//need to sort out itinerary ids in db. theyre going in as 0;
			Itinerary::create([
				'name'=>$itins[$i],
				'blurb'=>$itins[$i+1],
				//'time'=>$itins[$i+2],
				'prebooked'=>$prebooked,
				'cost'=>$itins[$i+3]
				]);
			$itineraryID = Itinerary::max('id');
			//return $eventID;
			EventContain::create([
				'itineraryId'=>$itineraryID,
				'event_id'=>$eventID
				]);

		}
		
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
			return view('events.browse', compact('events'));
	}

	public function show($id) {
			$event = EventDetail::findOrFail($id);
			$organisations = DB::table('organisations')
								->whereIn('id', function($query) use ($id) {
										$query->select('organisation_id')
										->from('organises')
										->where('event_id', '=', '?')
										->setBindings([$id]);
								})->first();
			
			
			$organisation = Organisation::findOrFail($organisations->id);
			return view('events.event', array('event' => $event, 'org' => $organisation));
	}	
}
