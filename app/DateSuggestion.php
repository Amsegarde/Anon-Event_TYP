<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class DateSuggestion extends Model {

	protected $fillable = [
				'start_date',
				'end_date',
				'event_id'
	];

}
