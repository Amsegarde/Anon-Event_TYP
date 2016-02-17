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
			$table->string('name');
			//consider removing date. it is redundant with datetime below
			$table->date('date');
			$table->dateTime('time');
			$table->string('blurb');
			$table->boolean('prebooked');
			$table->integer('cost');
			$table->integer('capacity');
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
