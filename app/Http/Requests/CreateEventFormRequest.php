<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Admin;
use Auth;
class CreateEventFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		//Make sure the user is logged in and is an admin
		$isUserAdmin = Admin::where('user_id','=', Auth::user()->id)->first();
		
		if(Auth::check() && !is_null($isUserAdmin) ){
			return true;
		}
		else{
			return false;
		}	
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'required',
    		'organisation' => 'required',
    		'bio' => 'required'
		];
	}

}
