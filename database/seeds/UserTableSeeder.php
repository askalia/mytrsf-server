<?php

use Illuminate\Database\Seeder;
use App\Entities\User;

use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('user')->delete();

		// chris
		User::create(array(
				'lastname' => 'Sevilleja',
				'firstname' => 'chris',
				'username' => 'Chris s.',
				'email' => 'chris@scotch.io',
				'password' => Hash::make('secret')
			));
	}
}