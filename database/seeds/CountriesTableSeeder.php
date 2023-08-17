<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Country;

class CountriesTableSeeder extends Seeder {

    public function run()
    {

        DB::table('countries')->truncate();

        $countries = array(
            array('iso2' => 'AO', 'iso3' => 'AGO','name' => 'Angola','status' => 'Non Contracting'),
			array('iso2' => 'BJ', 'iso3' => 'BEN','name' => 'Benin','status' => 'Non Contracting'),
            array('iso2' => 'BW', 'iso3' => 'BWA','name' => 'Botswana','status' => 'Contracting'),
            array('iso2' => 'BI', 'iso3' => 'BDI','name' => 'Burundi','status' => 'Contracting'),
            array('iso2' => 'KM', 'iso3' => 'COM','name' => 'Comoros','status' => 'Contracting'),
            array('iso2' => 'CD', 'iso3' => 'COD','name' => 'Congo DRC','status' => 'Non Contracting'),
			array('iso2' => 'CI', 'iso3' => 'CIV','name' => 'Ivory Coast','status' => 'Non Contracting'),
            array('iso2' => 'DJ', 'iso3' => 'DJI','name' => 'Djibouti','status' => 'Non Contracting'),
            array('iso2' => 'ER', 'iso3' => 'ERI','name' => 'Eritrea','status' => 'Non Contracting'),
			array('iso2' => 'GH', 'iso3' => 'GHA','name' => 'Ghana','status' => 'Non Contracting'),
			array('iso2' => 'SZ', 'iso3' => 'SWZ','name' => 'Swaziland','status' => 'Contracting'),
            array('iso2' => 'ET', 'iso3' => 'ETH','name' => 'Ethiopia','status' => 'Contracting'),
            array('iso2' => 'KE', 'iso3' => 'KEN','name' => 'Kenya','status' => 'Contracting'),   
            array('iso2' => 'LS', 'iso3' => 'LSO','name' => 'Lesotho','status' => 'Contracting'),
            array('iso2' => 'MG', 'iso3' => 'MDG','name' => 'Madagascar','status' => 'Non Contracting'),
            array('iso2' => 'MW', 'iso3' => 'MWI','name' => 'Malawi','status' => 'Contracting'),
			array('iso2' => 'MU', 'iso3' => 'MUS','name' => 'Mauritius','status' => 'Contracting'),
			array('iso2' => 'MA', 'iso3' => 'MAR','name' => 'Morocco','status' => 'Non Contracting'),
            array('iso2' => 'MZ', 'iso3' => 'MOZ','name' => 'Mozambique','status' => 'Non Contracting'),
            array('iso2' => 'NA', 'iso3' => 'NAM','name' => 'Namibia','status' => 'Contracting'),
			array('iso2' => 'NG', 'iso3' => 'NGA','name' => 'Nigeria','status' => 'Non Contracting'),
            array('iso2' => 'RW', 'iso3' => 'RWA','name' => 'Rwanda','status' => 'Contracting'),
			array('iso2' => 'SN', 'iso3' => 'SEN','name' => 'Senegal','status' => 'Non Contracting'),
            array('iso2' => 'SC', 'iso3' => 'SYC','name' => 'Seychelles','status' => 'Contracting'),
            array('iso2' => 'SO', 'iso3' => 'SOM','name' => 'Somalia','status' => 'Contracting'),
            array('iso2' => 'ZA', 'iso3' => 'ZAF','name' => 'South Africa','status' => 'Contracting'),
			array('iso2' => 'SS', 'iso3' => 'SSD','name' => 'South Sudan','status' => 'Contracting'),
            array('iso2' => 'SD', 'iso3' => 'SDN','name' => 'Sudan','status' => 'Contracting'),
            array('iso2' => 'TZ', 'iso3' => 'TZA','name' => 'Tanzania','status' => 'Contracting'),
            array('iso2' => 'UG', 'iso3' => 'UGA','name' => 'Uganda','status' => 'Contracting'),
            array('iso2' => 'ZM', 'iso3' => 'ZMB','name' => 'Zambia','status' => 'Contracting'),
            array('iso2' => 'ZW', 'iso3' => 'ZWE','name' => 'Zimbabwe','status' => 'Contracting'),
        );


		
		for($i = 0; $i < count($countries); $i++){
			$country = Country::create([
				'iso2' => $countries[$i]['iso2'],
				'iso3' => $countries[$i]['iso3'],
				'name' => $countries[$i]['name'],
				'status' => $countries[$i]['status']
				
			]);
			
			
		}
    }
}