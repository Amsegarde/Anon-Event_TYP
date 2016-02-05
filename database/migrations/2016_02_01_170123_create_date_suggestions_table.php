<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDateSuggestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('date_suggestions', function(Blueprint $table)
		{
			$table->integer('event_id')->unsigned();
			$table->integer('start_date')->unsigned();
			$table->primary(['event_id','start_date']);
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
		Schema::drop('date_suggestions');
	}

}
