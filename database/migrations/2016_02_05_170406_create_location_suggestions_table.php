<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationSuggestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('location_suggestions', function(Blueprint $table)
		{
			$table->integer('event_id');
			$table->integer('votes');
			$table->increments('id');
			$table->string('location');
			$table->unique(['event_id','location']);
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
		Schema::drop('location_suggestions');
	}

}
