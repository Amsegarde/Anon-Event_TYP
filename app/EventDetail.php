<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model {

	protected $fillable = ['name','bio', 'image', 'date', 'Location',
							'no_tickets', 'avail_tickets', 'price', 'genre',
							'keywords/tags', 'scope', 'active'];
}
