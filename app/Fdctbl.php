<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Fdctbl extends Model {
	
	public $timestamps = false;
	
	protected $table = 'fdctbl';
	
	protected $primaryKey = '_data_id';

    protected $fillable = ['_station_name','_prob_non_exc','_prob_exc','_data_value_obs','_data_value_sim','_data_value_obs_m3day','_days_1','_days_2','_data_vol','_data_cum_vol'];
	
	
    


    

    
}