<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {

	protected $table = 'supplier';
	public $timestamps = true;
	protected $fillable = array('name');
	protected $visible = array('name');

}