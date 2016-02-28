<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model {

	protected $table = 'medias';
	protected $fillable = ['event_id', 'media','user_id', 'flagged'];
	//

}
