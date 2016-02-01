<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganisationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organisation', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('organisation');
			$table->string('eventname');
			$table->string('email')->unique();
			$table->string('bio', 160);
			$table->rememberToken();
			$table->timestamps();
			$table->timestamp('published_on');
		});		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('organisation');
	}

}
