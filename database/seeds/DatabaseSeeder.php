<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Organise;
use App\Organisation;
use App\Admin;
use App\Event;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$u = new User;
		$u->firstname = 'Amy2';
		$u->email = 'test@amy.ie';
		$u->password =bcrypt('aaaaaa');
		$u->save();

		$org = new Organisation;
		$org->name ="Amy's Organisation";
		$org->bio='This is the best!';
		$org->scope ='0';
		$org->image='jpg';
		$org->save();

		Admin::create([
			'user_id'=>$u->id,
			'organisation_id'=>$org->id
			]);

		$ev = new Event;
		$ev->name = 'Event'; 
		$ev->bio = "This is the best event ever" ;
		$ev->image = "jpg";
		$ev->no_tickets = 10;
		$ev->avail_tickets = 10;
		$ev->price = 20;
		$ev->genre = 2;
		$ev->active = 1;
		$ev->scope = 0;
		$ev->save();

		Organise::create([
			'organisation_id' => $u->id,
			'event_id'=> $ev->id
			]);


		Category::create(['type' => 'Music', 
					'type' => 'Sport', 
					'type' => 'Theatre',
					'type' => 'Convention',
					'type' => 'Course',
					'type' => 'Conference',
					'type' => 'Seminar',
					'type' => 'Gaming',
					'type' => 'Party',
					'type' => 'Screening',
					'type' => 'Tour',
					'type' => 'Other'
					]);
	}

}
