<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('bio',500);
			$table->string('image');
			$table->dateTime('start_date')->nullable();
			$table->dateTime('end_date')->nullable();
			$table->string('location')->nullable();
			$table->integer('no_tickets');
			$table->integer('avail_tickets');
			$table->integer('price');
			$table->string('genre');
			//active is zero if polls arent used. one if polls are in progress and 2 if poll is closed
			$table->integer('active');
			$table->string('scope'); // local, regional, national, international
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
		Schema::drop('event_details');
	}

}
