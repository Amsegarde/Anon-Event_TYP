<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model {

	protected $fillable = [
				'ticket_type_id',
				'event_id'
	];


}
