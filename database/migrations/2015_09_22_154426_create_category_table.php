<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryTable extends Migration {

	public function up()
	{
        Schema::create('category', function(Blueprint $table) {
			$table->increments('id');
			$table->string('keyname', 50);
			$table->integer('supplier_id')->unsigned()->default('1');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('category');
	}
}