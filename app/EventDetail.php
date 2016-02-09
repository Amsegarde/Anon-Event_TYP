<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model {

	protected $fillable = ['name','bio', 'image', 'start_date', 'end_date', 'Location',
							'no_tickets', 'avail_tickets', 'price', 'genre',
							'keywords/tags', 'scope', 'active'];
}
