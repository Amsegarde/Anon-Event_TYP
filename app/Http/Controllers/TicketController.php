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

		$tickets = DB::table('event_details')
						->join('tickets','event_details.id', '=', 'tickets.event_id')
						->join('users', 'tickets.user_id', '=', 'users.id')
						->select(
							'event_details.name', 
							'event_details.date',
							'event_details.Location',
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

	public function store(Request $request, $id)
	{

		$ticket = new Ticket;
		$ticket->user_id = Auth::user()->id;
		$ticket->event_id = $id;
		$ticket->save();
		echo $ticket;
		return redirect('tickets');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		echo '<button>';
			echo '<a href="/events/{!! $event->id !!}/ticket/confirm">Get Ticket</a>';
		echo '</button>';
		return 'this is a tecket for event number' . $id;

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
