<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_info', function(Blueprint $table)
		{
			$table->increments('unique_id');
			$table->integer('user_id');
			$table->integer('event_id');
			$table->date('transaction_date');
			$table->datetime('transaction_time');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ticket_info');
	}

}
