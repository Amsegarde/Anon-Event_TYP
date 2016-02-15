<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('bio',500);
			$table->string('image');
			$table->dateTime('start_date')->nullable();
			$table->dateTime('end_date')->nullable();
			$table->string('Location')->nullable();
			$table->integer('no_tickets');
			$table->integer('avail_tickets');
			$table->integer('price');
			$table->string('genre');
			
			$table->boolean('active');
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
