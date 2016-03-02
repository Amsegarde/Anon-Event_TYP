<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model {

	protected $fillable = ['user_id', 
			            	'ticket_type',
			            	'price',
			            	'quantity',
			            	'stripe_transaction_id'
			            	];

}
