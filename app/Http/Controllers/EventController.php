<?php namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use App\Http\Requests\CreateEventFormRequest;
use App\Http\Controllers\Controller;
use Auth;
use App\Admin;
use App\Organisation;
use DB;
use Input;
use Illuminate\Http\Request;
use App\Event;
use App\Organise;
use Carbon\Carbon;
use App\Itinerary;
use App\EventContain;
use App\TicketType;
use App\EventTicket;
use App\LocationSuggestion;
use App\Ticket;
use App\DateSuggestion;
use App\User;
use Mail; 

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
	public function create(){
		$id = Auth::id();
		$organisations = DB::table('organisations')
								->whereIn('id', function($query) use ($id) {
										$query->select('organisation_id')
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

		//$carbonStart = $carbon->createFromFormat('d-m-Y', $start_date)->toDateString();
		//$carbonEnd = $carbon->createFromFormat('d-m-Y', $end_date)->toDateString();
		
		$newEvent = new Event;

		$newEvent->name = $request->name;
		$newEvent->bio = $request->bio;

		// $newEvent->start_date = $start_date->toDateTimeString();
		// $newEvent->end_date = $end_date->toDateTimeString();
		// $newEvent->Location = $request->location;
		$newEvent->no_tickets = $request->no_tickets;
		$newEvent->avail_tickets = $request->no_tickets;
		$newEvent->price = $request->price;
		$newEvent->genre = $request->genre;
		$newEvent->scope = $request->scope;

		$newEvent->save();

		/**
		* change the name of the file and save it !!!! :D
		*
		*/

		if (Input::hasFile('image')){
			$imageFile = Input::file('image');
			$imageName = $newEvent->id . '.' . $imageFile->getClientOriginalExtension(); 

			$destinationPath = base_path() . '/public/images/events/';

			Input::file('image')->move($destinationPath, $imageName);
			$newEvent->image = $imageFile->getClientOriginalExtension();	
		} else {
			$newEvent->image = null;
		}
		$newEvent->save();

		$eventID = $newEvent->id;

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
			
			$itinerary = new Itinerary;
			$itinerary->name = $itins[$i];
			$itinerary->blurb = $itins[$i+1];
			//$itinerary->time = $itins[$i+2];
			$itinerary->prebooked = $prebooked;
			$itinerary->cost = $itins[$i+3];

			$itinerary->save();
			$itineraryID = $itinerary->id;
			//return $eventID;
			EventContain::create([
				'itineraryId'=>$itineraryID,
				'event_id'=>$eventID
				]);
		}

		$tickets = $request->tickets;
		$size = count($tickets);
		for($i = 0; $i < $size; $i += 2) {
			$newTicket = new TicketType;
			$newTicket->type = $tickets[$i];
			$newTicket->event_id = $eventID;
			if ($tickets[$i] == 'free' ) {
				$newTicket->price =0;
			} else {
				$newTicket->price = $tickets[$i + 1];
			}
			$newTicket->event_id = $eventID;
			$newTicket->save();
		}		

		if(count($request->location)>1){
			$active = 1;
			$location = "To Be Decided";
			$suggestions = $request->location;
			for($i = 0; $i <count($suggestions); $i++){
				LocationSuggestion::create(['location'=>$suggestions[$i],
					'votes'=>0,
					'event_id'=>$eventID]);
			}

		}else{
			$active = 0;
			$location = $request->location[0];
		}
		if(count($request->start_date)>1){
			
			$start_date = null;
			$end_date = null;
			$start_dateSuggs = $request->start_date;
			$end_dateSuggs = $request->end_date;
			
			for($i = 0; $i <count($start_dateSuggs); $i+=2){
				DateSuggestion::create(['start_date'=>new Carbon($start_dateSuggs[$i]),
										'end_date'=>new Carbon($end_dateSuggs[$i]),
										'event_id'=>$eventID]);

			}

		}else{
			//return "only one apparantly";
			$start_date = new Carbon($request->start_date[0]);
			$end_date = new Carbon($request->end_date[0]);
			$newEvent->start_date = $start_date->toDateTimeString();
		$newEvent->end_date = $end_date->toDateTimeString();
			
			//TODO: ensure that dates are coming from event.blade correctly
			//store dates in db (update db first)
		}

		$newEvent->active = $active;
		$newEvent->location= $location;
		$newEvent->save();

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
	 * Show the events available
	 *
	 * @return Response
	 */
	public function browse(){
		//needs users filters and scope filters and some kind of algorithm
		//needs to be relevant events not just all.
			$events = Event::all();
			$search = Event::all();
			return view('events.browse', compact('events', 'search'));
	}

	/**
	 * Apply the filters to the browse
	 *
	 * @return Response
	 */
	public function filter(Request $request) {
		$events = new Event;

		if ($request->location){
			$events = $events->where('location', '=', $request->location)->get();
		}

		if ($request->genre) {
			$events = Event::where('genre','=', $request->genre)->get();
		}

		if ($request->price) {
			$events = Event::where('price', '<=', $request->price)->get();
		}

		$search = Event::all();

		return redirect('events')->with(compact('events','search'));
		// return redirect('events')->with(array($search, $events));
		// return redirect::action('',array('events','search'));
	}

	public function show($id) {
			$isAdmin = false;
			$userID = Auth::id();
			$event = Event::findOrFail($id);
			$organises = Organise::findOrFail($event->id);

	
			$organisation = Organisation::findOrFail($organises->organisation_id);

			$admins = DB::table('admins')
								->where('organisation_id', '=', $organisation->id)
								->where('user_id', '=', $userID)
								->get();

			foreach ($admins as $admin) {
				if ($admin->user_id == $userID) {
					$isAdmin = true;
					break;
				}
			}


			// get the tickets to the event
			$e = Event::findOrFail($id);
			$tickets = TicketType::where('event_id', '=', $e->id)->get();
			//decide on showing location poll
			$locations = $e->location;
			$locationSuggs = null;
			if($locations=="To Be Decided"){
				$locationSuggs = LocationSuggestion::where('event_id', '=',$e->id)->get();
			}

			// Get itinerary for the events;
			$itin = DB::table('itinerarys')
				->join('event_contains', 'itinerarys.id', '=', 'event_contains.itinerary_id')
				->where('event_contains.event_id', '=', $e->id)->get();
			
			return view('events.event', compact(
				'event', 
				'organisation',
				'isAdmin',
				'tickets',
				'locationSuggs',
				'itin'
			));

	}	

	/**
	 * Display events by this user only.
	 *
	 * @return view of events.
	 */
	public function manageEvents() {


		$id = Auth::user()->id;

		$events = DB::table('events')
						->join('organises','events.id', '=', 'organises.event_id')
						->join('admins', 'organises.organisation_id', '=', 'admins.organisation_id')
						->select(
							'events.name', 
							'events.start_date',
							'events.end_date',
							'events.location',
							'events.id',
							'events.image')
						->where('admins.user_id', '=', $id)							
					    ->get();

		// $admin = Admin::findOrFail($id);
		// $organises = Organise::where('organisation_id', '=', $admin->organisation_id);

		// $events = Event::where('id', '=', $organises->event_id);
		return view('events.manage', compact('events'));
	}

	public function sendMessage(Request $request) {

		$tickets = Ticket::where('event_id', '=', $request->eventID)->get();
		$event = Event::findOrFail($request->eventID);
		$organisation = Organisation::findOrFail($request->organisationID);

		foreach($tickets as $ticket) {

			$user = User::findOrFail($ticket->user_id);

			Mail::send('emails.attendees',
		       array(
		            'title' => $request->title,
		            'msg' => $request->message,
		            'organisation' => $organisation,
		            'event' => $event
		        ), function($message) use ($user, $request, $organisation)  {
		       			
	       				$message->to($user->email, $user->firstname)
	       						->from('anonevent.cs@gmail.com')
	       						->subject('Message from ' . $organisation->name);
		    });
		}

		return redirect('events/' . $request->eventID);
	}
}
