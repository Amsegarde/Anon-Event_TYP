<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItineraryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('itinerary', function(Blueprint $table)
		{
			$table->increments('itinerary_id');
			$table->string('name');
			$table->date('date');
			$table->dateTime('time');
			$table->string('blurb');
			$table->boolean('prebooked');
			$table->integer('additional cost');
			$table->integer('capacity');
			$table->rememberToken();
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
		Schema::drop('itinerary');
	}

}