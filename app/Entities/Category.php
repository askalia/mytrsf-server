<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $table = 'category';
	public $timestamps = true;
	protected $fillable = array('keyname', 'supplier_id');
	protected $visible = array('keyname', 'supplier_id');

}