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

class OrganisationController extends Controller {

	/**
	 * Display a listing of the resource.
	 * Display the Dashboard
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return view('organisation.organisation');
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
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//

		$org = Organisation::findOrFail($id);
		return view('organisation.organisation', array('org' => $org));
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
