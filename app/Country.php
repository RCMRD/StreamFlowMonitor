<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model {

	public $timestamps = false;
	
	
	protected $fillable = ['iso2','iso3','name','status'];

}