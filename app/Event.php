<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

	protected $fillable = ['name', 
						'bio',
						'image',
						'start_date',
						'end_date',
						'location',
						'no_tickets',
						'avail_tickets',
						'price', 
						'genre',
						'keywords/tags',
						'active', 
						'scope'];
}
