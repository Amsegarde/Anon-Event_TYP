<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrebooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prebooks', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('itinerary_id')->unsigned();
			$table->unique(['user_id','itinerary_id']);
			$table->increments('id');
			
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
		Schema::drop('prebooks');
	}

}
