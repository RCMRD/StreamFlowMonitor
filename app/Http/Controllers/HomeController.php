<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;



use App\Victbl;
use App\Fdctbl;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
       
		return view('index');
    }
	

	
	public function stationvic($station){
		
		
	return Victbl::where('_station_name',$station)->orderBy('_data_date','ASC')->get();
	}
	
	public function stationfdc($station){
		
		
	return Fdctbl::where('_station_name',$station)->orderBy('_prob_exc','ASC')->get();
	}
	
	


}
