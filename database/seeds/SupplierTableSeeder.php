<?php

use Illuminate\Database\Seeder;
use App\Entities\Supplier;

class SupplierTableSeeder extends Seeder {

	public function run()
	{
		DB::table('supplier')->delete();

		// amazon
		Supplier::create(array(
            'id' => 1,
				'name' => 'amazon'
			));
	}
}