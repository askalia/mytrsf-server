<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductUser extends Model {

	protected $table = 'product_user';
	public $timestamps = true;

	public function userToProducts()
	{
		return $this->hasMany('Product', '"id"');
	}

	public function productsToUsers()
	{
		return $this->belongsToMany('User', '"id"');
	}

}