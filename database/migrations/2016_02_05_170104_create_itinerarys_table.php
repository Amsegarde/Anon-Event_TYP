<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItinerarysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('itinerarys', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('event_id');
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
		Schema::drop('itinerarys');
	}

}
