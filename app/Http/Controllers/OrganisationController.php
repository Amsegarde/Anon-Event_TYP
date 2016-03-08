<?php namespace App\Http\Controllers;

use App\Organisation;
use App\Organise;
use App\Event;
use App\Admin;
use App\FavouriteOrganisation;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeEmailRequest;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

use DB;
use Input;
use Mail;
use App\user;
//use URL;

class OrganisationController extends Controller {

	/**
	 * Display a listing of the resource.
	 * Display the organisations
	 *
	 * @return Response
	 */
	public function index()
	{
		$id = Auth::user()->id;
		$organisations = DB::table('organisations')
								->whereIn('id', function($query) use ($id) {
										$query->select('organisation_id')
										->from('admins')
										->where('user_id', '=', '?')

										->setBindings([$id]);
								})->orderBy('name', 'asc')->get();

		return view('organisation.index', compact('organisations'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$id = Auth::id();
		if($id == null){
			return redirect('/auth/login')->with('message', 
				'You must be logged in to create an organisation!');
		}else{
			return view('organisation.create');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

	public function store(Request $request)
	{
		$input = $request->all();

		$this->validate($request, [
			'name' => 'required|min:3|unique:organisations'
			]);

		// add organisation table
		$org = new Organisation;

		$org->name = $input['name'];
		$org->bio = $input['bio'];
		$org->scope = $input['scope'];

		$org->save();

		/**
		* change the name of the file and save it !!!! :D
		*
		*/
		if (Input::hasFile('image')){
			$imageFile = Input::file('image');
			$imageName = $org->id . '.' . $imageFile->getClientOriginalExtension(); 

			$destinationPath = base_path() . '/public/images/organisations/';

			Input::file('image')->move($destinationPath, $imageName);
			$org->image=$imageFile->getClientOriginalExtension();
			$org->save();
		}
		
		// End of Image save!!

		// Update admins table
		$id = $org->id;

		$admin = new Admin;
		$admin->user_id = Auth::user()->id;
		$admin->organisation_id = $id;
		$admin->save();

		echo $admin;

		if ($request->path() == 'events/create') {
			return redirect()->back();
		} else {
			return redirect('organisation/' . $id);
		}
	}

	/**
	 * Displays favourite or unfavourite button on organisations 
	 * for registered users, and no button if guest to website. 
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$hasFavourited = false;
		$isAdmin = false;
		$eventsArray = array();

		$userID = Auth::user()->id;
		$favUserId = DB::table('favourite_organisations')
										->select('user_id')
										->where('organisation_id', '=', $id)
										->get();

		foreach($favUserId as $favUser) {
			if ($userID === $favUser->user_id) {
				$hasFavourited = true;
				break;
			} 
		}

		

				
		$org = Organisation::findOrFail($id);
		$admins = DB::table('admins')
								->where('organisation_id', '=', $org->id)
								->where('user_id', '=', $userID)
								->get();

		foreach ($admins as $admin) {
				if ($admin->user_id == $userID) {
					$isAdmin = true;
					break;
				}
		}

		$organises = Organise::where('organisation_id', '=', $id)->get();
		foreach ($organises as $organise) {
			$event = Event::findOrFail($organise->event_id);
			array_push($eventsArray, $event);
		}

		return view('organisation.organisation', array(
						'org' => $org, 
						'hasFavourited' => $hasFavourited,
						'isAdmin' => $isAdmin,
						'events' => $eventsArray));
	}

	/**
	 * View the organisation dashboard.
	 *
	 * @return organisation dashboard.
	 */
	public function dashboard()
	{
		//
		return view('organisation.dashboard');
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
	 * Favourite an organisation.
	 *
	 * @return organisation page.
	 */
	public function favourite($id) {
		$userID = Auth::user()->id;
		$favUserId = DB::table('favourite_organisations')
										->select('*')
										->where('user_id', '=', $userID)
										->where('organisation_id', '=', $id)
										->get();

		
		if (count($favUserId) == 0) {
			$favourite = new FavouriteOrganisation;
			$favourite->user_id = Auth::user()->id;
			$favourite->organisation_id = $id;
			$favourite->save();	
		} else {
			DB::table('favourite_organisations')
							->where('user_id', '=', $userID)
							->where('organisation_id', '=', $id)
							->delete();
		}

		return redirect('organisation/' . $id);
	}

	/**
	 * Favourite an organisation.
	 *
	 * @return organisation page.
	 */
	public function unFavourite($id) {

		$userID = Auth::user()->id;
		$unfavourite = DB::table('favourite_organisations')
										->where('organisation_id', '=', $id)
										->where('user_id', '=', $userID)
										->delete();

		return redirect('organisation/' . $id);
	}	

	/**
	 * Displays the users favourited organisations.
	 *
	 */
	public function myFavourites() {
		$id = Auth::user()->id;
		$organisations = DB::table('organisations')
				->whereIn('id', function($query) use ($id) {
										$query->select('organisation_id')
										->from('favourite_organisations')
										->where('user_id', '=', '?')
										->setBindings([$id]);
								})->get();


		return view('organisation.favourites', compact('organisations'));
	}

	/**
	 * Contact users who follow this organisation.
	 *
	 * @return organisation page
	 */
	public function contactFollowers(Request $request, $id) {
		$followers = FavouriteOrganisation::where('organisation_id', '=', $request->organisationID)->get();
		$organisation = Organisation::findOrFail($request->organisationID);

		foreach($followers as $follower) {

			$user = User::findOrFail($follower->user_id);

			Mail::send('emails.followers',
		       array(
		            'title' => $request->title,
		            'msg' => $request->message,
		            'organisation' => $organisation
		        ), function($message) use ($user, $request, $organisation)  {
		       			
	       				$message->to($user->email, $user->firstname)
	       						->from('anonevent.cs@gmail.com')
	       						->subject('Anon-Event | ' . $organisation->name);
		    });
		}

		return redirect('organisation/' . $request->organisationID);
	}

	public function contact(Request $request) {
		$admins = Admin::where('organisation_id', '=', $request->organisationID)->get();


		foreach ($admins as $admin) {
			$user = User::findOrFail($admin->user_id);
			Mail::send('emails.organisation_contact',
		       array(
		            'title' => $request->title,
		            'msg' => $request->message,
		        ), function($message) use ($user, $request)  {
		       			
	       				$message->to($user->email, $user->firstname)
	       						->from(Auth::user()->email)
	       						->subject($request->title);
		    });
		}
		return redirect('tickets/' . $request->ticketID);
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

	/**
	 * Get the account settings for the registered user.
	 *
	 * @return View
	 */
	public function getAccount() {

		if(Auth::check()){
			$id = Auth::user()->id;
			return redirect('users/' . $id . '/account');
		}else {
			return redirect('/auth/login')->with('message', 
				'You must be logged in to create an organisation!');
			
		}
	}

	/**
	 * Return view of the users account settings.
	 *
	 * @param $id of user account.
	 * @return View account settings
	 */
	public function account($id) {
		if(Auth::check()){
			$user = User::findOrFail($id);
		return view('users.account', compact('user'));
		} else {
			return redirect('/auth/login')->with('message', 
				'You must be logged in to create an organisation!');	
		}
	}

	/**
	 * Update the user details of the account.
	 *
	 * @param Request form details.
	 * @return Redirect to updated account page
	 */
	public function updateAccountDetails(Request $request) {
		$id = $request->userID;

		$fName = $request->firstname;
		$lName = $request->lastname;

		$updateDetails = User::where('id', '=', $id)
            						->update([
            							'firstname' => $fName,
            							'lastname' => $lName]);

        return view('users.account', compact('user'));
	}

	/**
	 * Update the user email of account.
	 *
	 * @param Request form details.
	 * @return Redirect to updated account page
	 */
	public function updateAccountEmail(ChangeEmailRequest $request) {
		$id = $request->userID;

		$email = $request->userEmail;
		$password = $request->password;

		if (Auth::attempt(array('email' => $email, 'password' => $password))){
            $updateEmail = User::where('id', '=', $id)
            						->update(['email' => $request->email]);
            $user = User::findOrFail($id);
            return view('users.account', compact('user'));
        } else {
        	return redirect('users/' . $id . '/account')
        				->withErrors([
							'password' => $this->getFailedLoginMessage(),
						]);
        }
	}

	/**
	 * Get the failed login message.
	 *
	 * @return string
	 */
	protected function getFailedLoginMessage()
	{
		return 'Your password is incorrect!';
	}

	/**
	 * Update organisation details.
	 *
	 * @param Request form details.
	 * @return show organisaiton.
	 */
	public function updateOrganisation(Request $request) {
		$id = $request->organisationID;

		$name = $request->name;
		$bio = $request->orgBio;
		$image = null;
		if (Input::file('image')){
			$imageFile = Input::file('image');
			$imageName = $id . '.' . $imageFile->getClientOriginalExtension(); 
			$destinationPath = base_path() . '/public/images/organisations/';

			Input::file('image')->move($destinationPath, $imageName);
			$image = $imageFile->getClientOriginalExtension();
		
		} else {
			return 'false';
		}

		$updateDetails = Organisation::where('id', '=', $id)
            						->update([
            							'name' => $name,
            							'bio' => $bio,
            							'image' => $image
        ]);
       	return $this->show($id);
	}

	public function addAdmin(Request $request) {
		$userID = Auth::user()->id;
		$orgID = $request->organisationID;
		
		if (User::where('email', '=', Input::get('email'))->exists()) {
			$user = User::where('email', '=', $request->email)->first();
			$admin = new Admin;
			$admin->user_id = $user->id;
			$admin->organisation_id = $orgID;
			$admin->save();
			return redirect('organisation/' . $orgID);
		} else {
			return Redirect::back()->with('message','That is not a registered email!');
		}
	}

	/**
	 * Get the failed registered email error.
	 *
	 * @return string
	 */
	protected function getFailedEmailMessage()
	{
		return 'That is not a regisered email!';
	}
}
