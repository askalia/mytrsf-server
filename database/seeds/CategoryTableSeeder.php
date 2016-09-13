<?php

use Illuminate\Database\Seeder;
use App\Entities\Category;

class CategoryTableSeeder extends Seeder {

	public function run()
	{
		DB::table('category')->delete();

		// Wireless
		Category::create(array(
				'keyname' => 'Wireless',
				'supplier_id' => 1
			));

		// Arts and crafts
		Category::create(array(
				'keyname' => 'artsandcrafts',
				'supplier_id' => 1
			));

		// Miscellaneous
		Category::create(array(
				'keyname' => 'Miscellaneous',
				'supplier_id' => 1
			));

		// Electronics
		Category::create(array(
				'keyname' => 'Electronics',
				'supplier_id' => 1
			));

		// Jewelry
		Category::create(array(
				'keyname' => 'Jewelry',
				'supplier_id' => 1
			));

		// Photo
		Category::create(array(
				'keyname' => 'Photo',
				'supplier_id' => 1
			));

		// Shoes
		Category::create(array(
				'keyname' => 'Shoes',
				'supplier_id' => 1
			));

		// Automotive
		Category::create(array(
				'keyname' => 'Automotive',
				'supplier_id' => 1
			));

		// Musical instruments
		Category::create(array(
				'keyname' => 'MusicalInstruments',
				'supplier_id' => 1
			));

		// GourmetFood
		Category::create(array(
				'keyname' => 'GourmetFood',
				'supplier_id' => 1
			));

		// HomeGarden
		Category::create(array(
				'keyname' => 'HomeGarden',
				'supplier_id' => 1
			));

		// UnboxVideo
		Category::create(array(
				'keyname' => 'UnboxVideo',
				'supplier_id' => 1
			));
	}
}