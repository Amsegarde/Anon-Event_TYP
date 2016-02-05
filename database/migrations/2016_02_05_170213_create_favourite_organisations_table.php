<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavouriteOrganisationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('favourite_organisations', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('organisation_id')->unsigned();
			$table->primary(['user_id','organisation_id']);
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
		Schema::drop('favourite_organisations');
	}

}
