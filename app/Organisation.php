<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model {

	// *
	//  * The database table used by the model.
	//  *
	//  * @var string
	 
	// protected $table = 'organisations';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'bio', 'scope', 'image'];

	public function events() {
		return $this->hasMany('App\EventDetail');
	}

}
