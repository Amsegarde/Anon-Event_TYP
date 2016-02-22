<?php namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use App\Http\Requests\CreateEventFormRequest;
use App\Http\Controllers\Controller;
use Auth;
use App\Admin;
use App\Organisation;
use DB;
use Illuminate\Http\Request;
use App\Event;
use App\Organise;
use Carbon\Carbon;
use App\Itinerary;
use App\EventContain;
use App\TicketType;
use App\EventTicket;
use App\LocationSuggestion;
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
		$start_date = new Carbon($request->start_date);
		$end_date = new Carbon($request->end_date);
		//$carbonStart = $carbon->createFromFormat('d-m-Y', $start_date)->toDateString();
		//$carbonEnd = $carbon->createFromFormat('d-m-Y', $end_date)->toDateString();
		
		$newEvent = new Event;
					$newEvent->name=$request->name;
						$newEvent->bio=$request->bio;
						//newEvent=>'image'=>$request->image,
						$newEvent->start_date=$start_date->toDateTimeString();
						// $newEvent->end_date=$end_date->toDateTimeString();
						// $newEvent->location=$location;
						$newEvent->no_tickets=$request->no_tickets;
						$newEvent->avail_tickets=$request->no_tickets;
						$newEvent->genre=$request->genre;
					//	'keywords/tags'=>$request->keywords_tags,
						//$newEvent->active=$active;
						$newEvent->scope=$request->scope;
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
			//need to sort out itinerary ids in db. theyre going in as 0;
			
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
			if ($tickets[$i] == 'free' ) {
				$newTicket->price =0;
			} else {
				$newTicket->price = $tickets[$i + 1];
			}
			$newTicket->save();
			$ticketID = $newTicket->id;

			$newEventTickets = EventTicket::create([
				'ticket_type_id' => $ticketID,
				'event_id' => $eventID
			]);
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
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function browse()
	{
		//needs users filters and scope filters and some kind of algorithm
		//needs to be relevant events not just all.
			$events = Event::all();
			return view('events.browse', compact('events'));
	}

	public function show($id) {
			$isAdmin = false;
			$userID = Auth::id();
			$event = Event::findOrFail($id);

			$organisations = DB::table('organisations')
								->whereIn('id', function($query) use ($id) {
										$query->select('organisation_id')
										->from('organises')
										->where('event_id', '=', '?')
										->setBindings([$id]);
								})->first();

	
			$organisation = Organisation::findOrFail($organisations->id);

			$admins = DB::table('admins')
								->where('organisation_id', '=', $organisations->id)
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
			return view('events.event', compact(
				'event', 
				'organisation',
				'isAdmin',
				'tickets' 
			));

			
			
			$organisation = Organisation::findOrFail($organisations->id);
			return view('events.event', array('event' => $event, 'org' => $organisation));
	}	
}
