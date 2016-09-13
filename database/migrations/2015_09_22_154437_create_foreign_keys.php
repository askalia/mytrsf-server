<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('product', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('category')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('product_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('user')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('product_user', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('product')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('category', function(Blueprint $table) {
			$table->foreign('supplier_id')->references('id')->on('supplier')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('product', function(Blueprint $table) {
			$table->dropForeign('product_category_id_foreign');
		});
		Schema::table('product_user', function(Blueprint $table) {
			$table->dropForeign('product_user_user_id_foreign');
		});
		Schema::table('product_user', function(Blueprint $table) {
			$table->dropForeign('product_user_product_id_foreign');
		});
		Schema::table('category', function(Blueprint $table) {
			$table->dropForeign('category_supplier_id_foreign');
		});
	}
}