<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrebookedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prebooked', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('itinerary_id')->unsigned();
			$table->primary(['user_id','itinerary_id']);
			
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
		Schema::drop('prebooked');
	}

}
