<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationSuggestion extends Model {

	protected $fillable = ['location', 'votes', 'event_id'];



}
