<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Victbl extends Model {
	
	public $timestamps = false;
	
	protected $table = 'victbl';
	
	protected $primaryKey = '_data_id';

    protected $fillable = ['_station_name','_station_country','_data_date','_data_value_sim','_data_value_obs'];
	
	
    


    

    
}