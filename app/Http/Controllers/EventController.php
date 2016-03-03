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
use App\Engage;
use App\LocationSuggestion;
use App\Ticket;
use App\DateSuggestion;
use App\Category;
use App\User;
use App\Vote;
use App\Media;
use Mail; 
use Illuminate\Support\Facades\Redirect;

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
		$loggedIn = true;
		$hasOrg = true;
		if($id == null){
			$loggedIn = false;
		}
		$organisations = DB::table('organisations')
								->whereIn('id', function($query) use ($id) {
										$query->select('organisation_id')
										->from('admins')
										->where('user_id', '=', '?')
										->setBindings([$id]);
								})->get();
		if($organisations == null){
			$hasOrg = false;
		}
		
		if($id == null){
			return redirect('/auth/login')->with('message', 
				'You must be logged in to create an event!');
		}
		else if($organisations == null){
			return redirect('organisation/create')->with('message', 
				'You must have an organisation to create an event!');
		}
		else{
			return view('events.create', compact('organisations',
												'loggedIn',
												'hasOrg'
											));
		}	
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
		$newEvent->price = 0;
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
			$itinerary->date = $itins[$i+2];
			$itinerary->prebooked = $prebooked;
			$itinerary->cost = $itins[$i+3];
			$itinerary->capacity = $itins[$i+4];

			$itinerary->save();
			$itineraryID = $itinerary->id;
			//return $eventID;
			EventContain::create([
				'itinerary_id'=>$itineraryID,
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
			
			for($i = 0; $i <count($start_dateSuggs); $i++){
				DateSuggestion::create(['start_date'=>new Carbon($start_dateSuggs[$i]),
										'end_date'=>new Carbon($end_dateSuggs[$i]),
										'event_id'=>$eventID]);

			}

		}else{

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
	public function browsePast(Request $request)
	{
		$events = new Event;
		// echo "1";
		if (!empty($request->all())) {
			// echo "2";
			if ($request->location){
				// echo "3";
				$events = Event::where('location', 'Like', $request->location)
						->where('start_date', '<', Carbon::now())->get();
			} 

			if ($request->date) {
				// echo "4";
				$carbon = new Carbon;
				$searchDate = $carbon->createFromFormat('j F, Y', $request->date);
				$events = Event::where('start_date', '>=', $searchDate)
						->where('start_date', '<', Carbon::now())->get();
			}

			if ($request->genre) {
				// echo "5";
				$events = Event::where('genre','=', $request->genre)
						->where('start_date', '<', Carbon::now())->get();
			}
		} else {
			// echo "6";
			$events = Event::where('start_date', '<', Carbon::now())->get();
		}
		if (count($events) == 0) {
			// echo "7";
			$msg = 'No Events match your search';
			$events = Event::where('start_date', '<', Carbon::now())->get();
		}
		else {
			// echo "8";
			$msg = count($events) . " event(s) found";
		}

		// echo "9";
		$genre = Category::all();
		return view('events.browsePast', compact('events', 'genre', 'msg'));
	}

	/**
	 * Show the events available
	 *
	 * @return Response
	 */
	public function browse(Request $request){
		//needs users filters and scope filters and some kind of algorithm
		//needs to be relevant events not just all.
		$events = new Event;

		if (!empty($request->all())) {
			if ($request->location){
				$events = $events->where('location', 'like', $request->location)
						->where('start_date', '>=', Carbon::now())->get();
			}

			if ($request->date) {
				$carbon = new Carbon;
				$searchDate = $carbon->createFromFormat('j F, Y', $request->date);
				$events = Event::where('start_date', '>=', $searchDate)
						->where('start_date', '>=', Carbon::now())->get();
			}

			if ($request->genre) {
				$events = Event::where('genre','=', $request->genre)
						->where('start_date', '>=', Carbon::now())->get();
			}

			if ($request->price) {
				$events = Event::where('price', '<=', $request->price)
						->where('start_date', '>=', Carbon::now())->get();
			}
		} else {
			$events = Event::where('start_date', '<', Carbon::now())->get();
		}

		if (count($events) == 0) {
			$msg = 'No Events match your search';
			$events = Event::where('start_date', '>=', Carbon::now())->get();
		}
		else {
			$msg = count($events) . " event(s) found";
		}
		
		$genre = Category::all();
		return view('events.browse', compact('events', 'genre', 'msg'));
	}

	public function show($id) {
			$isAdmin = false;
			$userID = Auth::id();
			$event = Event::findOrFail($id);
			$organises = Organise::findOrFail($event->id);
			$itinArrays = array();
			$itinerary = new Itinerary;
	
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

			$eventItins = EventContain::where("event_id", "=", $event->id)->get();
			//$actualItins = Itinerary::where("event_id", "=", $eventItins->id)->get();
			foreach($eventItins as $eventItin){
				$i = Itinerary::findOrFail($eventItin->itinerary_id);
				array_push($itinArrays, $i);
			}


			// get the tickets to the event
			$e = Event::findOrFail($id);
			$tickets = TicketType::where('event_id', '=', $e->id)->get();

			$voteOpen= 0;
			$voted = Vote::where('user_id','=', $userID)->where('event_id','=',$e->id)->first();
			if(empty($voted)){
				//return "voting is opne";
				$voteOpen = 1;
			}
			//decide on showing location poll
			$locations = $e->location;
			$locationSuggs = null;
			$start_dateSuggs = null;
			if($locations=="To Be Decided"){
				$locationSuggs = LocationSuggestion::where('event_id', '=',$e->id)->get();
			}
			$dateSuggs = DateSuggestion::where('event_id','=', $e->id)->get();
			

			return view('events.event', compact(
				'event', 
				'voteOpen',
				'organisation',
				'isAdmin',
				'tickets',
				'locationSuggs',
				'itinArrays',
				'itinerary',
				'dateSuggs'
			));


			if ($event->start_date >= Carbon::now()) { // All active events
				return view('events.event', compact(
					'event', 
					'voteOpen',
					'organisation',
					'isAdmin',
					'tickets',
					'locationSuggs',
					'itin',
					'itinArrays',
					'itinerary',
					'dateSuggs'
				));
			} else { // all past events
				$medias = Media::where('event_id', '=', $e->id)->get();
				return view('events.past', compact(
					'event', 
					'organisation',
					'isAdmin',
					'itin',
					'itinArrays',
					'itinerary',
					'medias'
				));
			}
				
	}	

	public function vote(Request $request){
		$userID = Auth::user()->id;
		$eventID = $request->eventID;
		$location = $request->location_vote;
		$date = $request->date_vote;
		
		Vote::create(['event_id'=>$eventID,'user_id'=>$userID]);
		$locVote = LocationSuggestion::where('id','=', $location)										
										->increment('votes');
		
		$dateVote = DateSuggestion::where('id','=', $date)										
										->increment('votes');
		
		
		return Redirect::back()->with('message','Operation Successful !');

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

	/**
	 * Select an aven to delete.
	 */
	public function delete($id) {
		$eventID = $id;
		return view('events.delete', compact('eventID'));
	}

	/**
	 * Delete an event. Removes data from all related tables.
	 *
	 *
	 */
	public function destroy(Request $request) {
		$event = Event::findOrFail($request->eventID);
		
		$delete_organise = Organise::where('event_id', '=', $request->eventID)->delete();
	

		$tickets = Ticket::where('event_id', '=', $request->eventID)->get();
		$delete_tickets = Ticket::where('event_id', '=', $request->eventID)->delete();
		$delete_ticketTypes = TicketType::where('event_id', '=', $request->eventID)->delete();
		

		$itinerarys = EventContain::where('event_id', '=', $request->eventID)->get();
		$delete_itinerarys = EventContain::where('event_id', '=', $request->eventID)->delete();

		if (count($itinerarys) > 0) {
			foreach ($itinerarys as $itinerary) {
				$delete_itinerary = Itinerary::where('id', '=', $itinerary->itinerary_id)->delete();
				$delete_prebooks = Prebook::where('id', '=', $itinerary->itinerary_id)->delete();
			}
		}
		

		$delete_engages = Engage::where('event_id', '=', $request->eventID)->delete();

		foreach ($tickets as $ticket) {
			$user = User::findOrFail($ticket->user_id);
			$prevUser = null;

			if ($prevUser == null || $user->id != $prevUser->id) {
				Mail::send('emails.event_cancelled',
			       array(
			            'name' => $event->name,
			        ), function($message) use ($user, $event)  {
			       			
		       			$message->to($user->email, $user->firstname)
		       				->from('anonevent.cs@gmail.com')
		       				->subject('Anon-Event | ' . $event->name . ' Cancelled!');
			    });
			    $prevUser = $user;
			}
				
		}

		$delete_event = Event::where('id', '=', $request->eventID)->delete();
		return redirect('events/manage');
	}

	public function media(Request $request) {
		$media = new Media;

		$media->event_id = $request->event_id;
		$media->user_id = $request->user_id;
		$media->flagged = false;
		$media->save();

		if (Input::hasFile('image')){
			$uploadFile = Input::file('image');
			$filename = $media->id . '.' . $uploadFile->getClientOriginalExtension(); 

			$destinationPath = base_path() . '/public/images/media/';

			Input::file('image')->move($destinationPath, $filename);
			$media->media = $uploadFile->getClientOriginalExtension();	
		} else {
			$media->media = '';
		}
		$media->save();

		return redirect::back()->with('message', 'Media Uploaded');

	}

	public function badges($id) {
		$tickets = Ticket::where('event_id', '=', $id)->get();
		$usersArray = array();
		$event = Event::findOrFail($id);

		foreach ($tickets as $ticket) {
			$user = User::findOrFail($ticket->user_id);
			array_push($usersArray, $user);
		}

		return view('events.badges', compact('tickets', 'usersArray', 'event'));
	}

	public function printBadges($id) {
		$tickets = Ticket::where('event_id', '=', $id)->get();
		$usersArray = array();
		$event = Event::findOrFail($id);
		foreach ($tickets as $ticket) {
			$user = User::findOrFail($ticket->user_id);
			array_push($usersArray, $user);
		}

		return view('events.printBadges', compact('tickets', 'usersArray', 'event'));
	}	
}
