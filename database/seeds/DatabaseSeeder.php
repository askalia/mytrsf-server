<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

        $this->call('SupplierTableSeeder');
        $this->command->info('Supplier table seeded!');

		$this->call('UserTableSeeder');
		$this->command->info('User table seeded!');

		$this->call('CategoryTableSeeder');
		$this->command->info('Category table seeded!');


	}
}