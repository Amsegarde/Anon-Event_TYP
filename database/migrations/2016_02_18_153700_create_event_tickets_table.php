<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateEventTicketsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_tickets', function(Blueprint $table)
		{
			$table->integer('ticket_type_id')->unsigned();
			$table->integer('event_id')->unsigned();
			$table->unique(['ticket_type_id','event_id']);
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
		Schema::drop('event_tickets');
	}
}