<?php

namespace App\Imports;

use App\Station;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

//use App\Station;
use App\Country;
use App\Agency;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;
use Phaza\LaravelPostgis\Geometries\Point;
use Phaza\LaravelPostgis\Geometries\LineString;
use Phaza\LaravelPostgis\Geometries\Polygon;

class StationImport implements OnEachRow, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow($row)

    {
		$row = $row->toArray();
		
		/*$country=Country::where('name',$row['country'])->first();
	    $agency=Agency::where('name',$row['agency'])->first();*/
		//$geom= new Point($row['latitude'],$row['longitude']);
        /*return new Station([
            //
			
			    'name' => $row['name'],
				'height' => $row['height'],
				'status' => $row['status'],
				'sampling_rate' => $row['rate'],
				'availability' => $row['availability'],
				'gnss' => $row['gnss'],
				'country_id' => $country->id,
				'agency_id' => $agency->id,
				'geom' => $geom,
        ]);*/
		
		//$co=$row['country'];
		//$ag=$row['agency'];
		
		$country=Country::where('name',$row['country'])->first();
		$agency=Agency::where('name',$row['agency'])->first();
		
		
		if(isset($country)){
			$country_id=$country->id;
		}else{
			$country_id=9;
		}
		
		if(isset($agency)){
			$agency_id=$agency->id;
		}else{
			$agency_id=1;
		}
		
		$station1 = new Station();
        $station1->name = $row['name'];
        $station1->country_id = $country_id;
        $station1->agency_id = $agency_id;
        $station1->height = $row['height'];
		$station1->status = $row['status'];
		$station1->sampling_rate = $row['rate'];
		$station1->data_availability = $row['data_availability'];
		$station1->data_link = $row['data_link'];
		$station1->receiver_satellite = $row['receiver_satellite'];
		$station1->gnss = $row['gnss'];
        $station1->geom = new Point($row['latitude'], $row['longitude']);


       $station1->save();

//return $station1;
		
		


    }
}
