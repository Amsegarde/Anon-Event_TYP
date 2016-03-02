<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_purchases', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('stripe_customer_id');
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
		Schema::drop('user_purchases');
	}

}
