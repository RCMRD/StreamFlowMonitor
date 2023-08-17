<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
//use App\Mail\ConfirmMailable;


use Excel;

use App\Station;
use App\Country;
use App\Agency;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\Polygon;



class ImportStations implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
	protected $file;
    public function __construct($file)
    {
        //
		$this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

	
	
	
	public function handle()
    {
        //
		$data = Excel::load($this->file, function($reader) {
			})->get();
			
		
					
					
					
        foreach($data as $value) {
               //Do stuff
			   
			   $country=Country::where('name',$value->country)->first();
			   $agency=Agency::where('name',$value->agency)->first();
			   
			   Station::create([
				'name' => $value->name,
				'height' => $value->height,
				'status' => $value->status,
				'sampling_rate' => $value->rate,
				'availability' => $value->availability,
				'gnss' => $value->gnss,
				'country_id' => $country->id,
				'agency_id' => $agency->id,
				'geom' => new Point($value->latitude,$value->longitude),
			]);
			

			  
			
					
				
					
				
				

               
		}			   
					
					
		
           
		
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
