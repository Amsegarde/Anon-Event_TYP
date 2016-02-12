<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model {

	public $table = "itinerarys";

	protected $fillable = ['name',
	'date',
	'time',
	'blurb',
	'prebooked',
	'additonal cost',
	'capacity',
	'event_id'];


}
