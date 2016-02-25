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
use App\Organise;

use App\Ticket;
use App\TicketType; 
use App\Event;
use App\UserPurchase;
use App\Purchase;

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
	 	// $tickets = Ticket::where('user_id', '=', $id);
	 	// $userTickets = EventTickets::findOrFail($id);
	 	// $events = Event::where('id', '=', $userTickets->event_id);

		$tickets = DB::table('events')
						->join('tickets','events.id', '=', 'tickets.event_id')
						->join('users', 'tickets.user_id', '=', 'users.id')
						->select(
							'events.name', 
							'events.start_date',
							'events.end_date',
							'events.location',
							'tickets.type',
							'tickets.quantity',
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
		$type = $request->type;
		$price = $request->price;
		$quantity = $request->quantity;
		$totalQuantity = $request->totalQuantity;

		$size = count($type);
		for($i = 0; $i< $size; $i++) { 
			$newTicket = Ticket::create([
						'user_id' 	=> $userID,
						'event_id' 	=> $request->eventID,
						'type'		=> $type[$i],
						'quantity'	=> $quantity[$i]
						
			]);
		
			$update = DB::table('events')
							->where('id', '=', $request->eventID)
							->decrement('avail_tickets', $totalQuantity);

		}

		

		return redirect('tickets');
	}


	/**
	 * Temporarely displays tickets.
	 */
	public function confirm(Request $request)
	{
		$event = Event::find($request->eventID);
		//$quantity = $request->quantity + 1;
		$type = $request->type;
		$price = $request->price;
		$quantity = $request->quantity;


		$tickets = TicketType::where('event_id', '=', $event->id)->get();

		$totals = array();
		$size = count($type);

		$totalPrice = 0;
		$totalQuantity = 0;

		for ($i = 0; $i < $size; $i++) {
			$sum = $price[$i] * $quantity[$i];
			$totalPrice += $sum;
			$totalQuantity += $quantity[$i];
			array_push($totals, $sum);
		};


		return view('events.confirmation', array(
									'request' 		=> $request, 
									'event' 		=> $event,
									'type' 			=> $type,
									'price' 		=> $price,
		 							'quantity' 		=> $quantity,
		 							'totals' 		=> $totals,
		 							'totalPrice' 	=> $totalPrice,
		 							'totalQuantity' => $totalQuantity,
		 							'tickets' 		=> $tickets));	


	}


   	public function postOrder(Request $request)
   	{
   		$userID = Auth::user()->id;
		$type = $request->type;
		$price = $request->price;
		$quantity = $request->quantity;
		$totalQuantity = $request->totalQuantity;

		$size = count($type);
		for($i = 0; $i< $size; $i++) { 
			$newTicket = Ticket::create([
						'user_id' 	=> $userID,
						'event_id' 	=> $request->eventID,
						'type'		=> $type[$i],
						'quantity'	=> $quantity[$i]
						
			]);
		}	
		
			$update = DB::table('events')
							->where('id', '=', $request->eventID)
							->decrement('avail_tickets', $totalQuantity);

        $validator = \Validator::make(\Input::all(), [
            'first_name' => 'required|string|min:2|max:32',
            'last_name' => 'required|string|min:2|max:32',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //return $request->totalPrice;
        // Checking is product valid
        $temp = $request->totalPrice;
        $amount = $temp * 100;

        $token = $request->input('stripeToken');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        // $temp = UserPurchase::where('email', $email)->first();//->value('email');
        // $emailCheck = $temp->email;
        \Stripe\Stripe::setApiKey(env('STRIPE_SK'));

        // If the email doesn't exist in the database create new customer and user record
        if (/*!isset($emailCheck)*/ UserPurchase::where('email', $email)->get()) {
            // Create a new Stripe customer
            try {
                $customer = \Stripe\Customer::create([
                'source' => $token,
                'email' => $email,
                'metadata' => [
                    "First Name" => $first_name,
                    "Last Name" => $last_name
                ]
                ]);
            } catch (\Stripe\Error\Card $e) {
                return redirect()->route('order')
                    ->withErrors($e->getMessage())
                    ->withInput();
            }

            $customerID = $customer->id;

            // Create a new user in the database with Stripe
            $user = UserPurchase::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'stripe_customer_id' => $customerID,
            ]);
        } else {
            $temp = UserPurchase::where('email', $email)->first();//->value('stripe_customer_id');
            $customerID = $temp->stripe_customer_id;
            $user = UserPurchase::where('email', $email)->first();
        }

        // Charging the Customer with the selected amount
        try {
            $charge = \Stripe\Charge::create([
                'amount' => $amount,
                'currency' => 'eur',
                'customer' => $customerID,
                ]);
        } catch (\Stripe\Error\Card $e) {
            return redirect()->route('display')
                ->withErrors($e->getMessage())
                ->withInput();
        }

        $ticket = new Ticket;
        // Create purchase record in the database
        Purchase::create([
            'user_id' => $user->id,
            'ticket_id' => $request->id,
            'ticket_type' => $request->type,
            'price' => $amount/100,
            'quantity' => $request->totalQuantity,
            'stripe_transaction_id' => $charge->id,
        ]);

        return redirect()->route('display')
            ->with('successful', 'Your purchase was successful!');
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
		$ticket = Ticket::findOrFail($id);
		$event = Event::findOrFail($ticket->event_id);
		$organises = Organise::findOrFail($event->id);
		$organisation = Organisation::findOrFail($organises->organisation_id);
		return view('tickets.ticket', compact('ticket', 'event', 'organisation'));
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
