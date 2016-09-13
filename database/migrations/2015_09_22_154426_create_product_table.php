<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTable extends Migration {

	public function up()
	{
        Schema::create('product', function(Blueprint $table) {
			$table->increments('id');
			$table->string('model', 255)->unique()->index();
			$table->string('brand', 100)->nullable();
			$table->integer('category_id')->unsigned();
			$table->string('small_picture', 255);
			$table->string('medium_picture', 255);
			$table->string('large_picture', 255);
			$table->string('ASIN', 50);
			$table->string('EAN', 50)->nullable();
			$table->string('ISBN', 50)->nullable();
			$table->string('webpage', 255);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('product');
	}
}