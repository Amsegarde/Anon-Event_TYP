<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventContainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_contains', function(Blueprint $table)
		{
			$table->integer('event_id')->unsigned();
		
			$table->increments('id');
			$table->integer('itinerary_id')->unsigned();
			//commented out by joe to remove a mysql conflict when creating event with itinerary items.
			//$table->unique(['event_id','itinerary_id']);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('event_contains');
	}

}
