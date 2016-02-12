<?php namespace App\Http\Controllers;

use App\Organisation;
use App\Admin;
use App\FavouriteOrganisation;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
//use Request;
use DB;
use Input;

class OrganisationController extends Controller {

	/**
	 * Display a listing of the resource.
	 * Display the Dashboard
	 *
	 * @return Response
	 */
	public function index()
	{
		$id = Auth::user()->id;
		$organisations = DB::table('organisations')
								->whereIn('id', function($query) use ($id) {
										$query->select('id')
										->from('admins')
										->where('user_id', '=', '?')
										->setBindings([$id]);
								})->get();

		return view('organisation.index', compact('organisations'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('organisation.create');
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
		}
		
		// End of Image save!!

		// Update admins table
		$id = $org->id;

		$admin = new Admin;
		$admin->user_id = Auth::user()->id;
		$admin->organisation_id = $id;
		$admin->save();

		echo $admin;

		return redirect('organisation/' . $id);
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
		return view('organisation.organisation', array(
						'org' => $org, 
						'hasFavourited' => $hasFavourited));
	}

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
	 * Displays the users favourited organisations.
	 *
	 */
	public function myFavourites() {
		$id = Auth::user()->id;
		DB::table('organisations')
				->whereIn('id', function($query) use ($id) {
										$query->select('organisation_id')
										->from('favourite_organisations')
										->where('user_id', '=', '?')
										->setBindings([$id]);
								})->get();

		return view('organisation.favourites', compact('organisations'));
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
