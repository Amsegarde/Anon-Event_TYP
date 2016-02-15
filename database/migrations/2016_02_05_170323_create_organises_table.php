<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganisesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organises', function(Blueprint $table)
		{
			$table->integer('event_id')->unsigned();
			$table->increments('id');
			$table->integer('organisation_id')->unsigned();
			$table->unique(['event_id','organisation_id']);
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
		Schema::drop('organises');
	}

}
