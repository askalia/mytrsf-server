<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductUserTable extends Migration {

	public function up()
	{
        Schema::create('product_user', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->boolean('is_shared')->default(false);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('product_user');
	}
}