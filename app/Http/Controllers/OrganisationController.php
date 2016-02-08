<?php namespace App\Http\Controllers;

use App\Organisation;
use App\Admin;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Request;
use DB;

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
	public function store()
	{
		$input = Request::all();

		Organisation::create($input);

		$id = Organisation::where('name', $input['name'])->first();

		$admin = new Admin;

		$admin->user_id = Auth::user()->id;
		$admin->organisation_id = $id->organisation_id;

		$admin->save();

		return $admin;
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
		//return view('organisation.dashboard');
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
