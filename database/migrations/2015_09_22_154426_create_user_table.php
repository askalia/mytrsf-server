<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	public function up()
	{
        Schema::create('user', function(Blueprint $table) {
			$table->increments('id');
			$table->string('lastname', 100)->nullable();
			$table->string('firstname', 100)->nullable();
			$table->string('username', 50)->unique()->nullable();
			$table->string('avatar', 255)->nullable();
			$table->string('email', 100);
			$table->string('password', 255);
			$table->timestamps();
			$table->rememberToken('rememberToken');
		});
	}

	public function down()
	{
		Schema::drop('user');
	}
}