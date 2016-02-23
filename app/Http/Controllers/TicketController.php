<?php namespace App\Http\Controllers;

use App\Organisation;
use App\Admin;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
//use Request;
use DB;
use Input;
use App\Ticket;
use App\TicketType; 
use App\Event;

class TicketController extends Controller {

	/**
	 * Return the tickets view showing all tickets secured 
	 * by the user.
	 *
	 * @return tickets purchased by the user
	 */
	public function index()
	{

	 	$id = Auth::user()->id;

		$tickets = DB::table('events')
						->join('tickets','events.id', '=', 'tickets.event_id')
						->join('users', 'tickets.user_id', '=', 'users.id')
						->select(
							'events.name', 
							'events.start_date',
							'events.end_date',
							'events.location',
							'tickets.id')
						->where('users.id', '=', '?')
						->setBindings([$id])								
					    ->get();
							
							
		return view('tickets.index', compact('tickets'));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Respons
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

	public function store(Request $request)
	{
		$userID = Auth::user()->id;

		$newEvent = Ticket::create([
						'user_id' 	=> $userID,
						'event_id' 	=> $request->eventID,
						'quantity'	=> $request->quantity
						
		]);
		
		$update = DB::table('events')
								->where('id', '=', $request->eventID)
								->decrement('avail_tickets', $request->quantity
						);


		return redirect('tickets');
	}


	/**
	 * Temporarely displays tickets.
	 */
	public function confirm(Request $request)
	{
		$event = Event::findOrFail($request->eventID);
		//$quantity = $request->quantity + 1;
		$type = $request->type;
		$price = $request->price;
		$quantity = $request->quantity;


		$tickets = TicketType::where('event_id', '=', $event->id)->get();

		$totals = array();
		$size = count($type);
		for ($i = 0; $i < $size; $i++) {
			$sum = $price[$i] * $quantity[$i];
			array_push($totals, $sum);
		};

		return view('events.confirmation', array(
									'request' => $request, 
									'event' => $event,
									'type' => $type,
									'price' => $price,
		 							'quantity' => $quantity,
		 							'totals' => $totals));	
	}

	/**
	 * Display the specified resource.
	 * Displays tickect confirmation page, to confirm user
	 * wants the tickets requested.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tickets = Event::findOrFail($id);
		return view('events.confirmation', compact('tickets'));
	}

	public function dashboard()
	{
		//
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
