<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//use MStaack\LaravelPostgis\Schema\Blueprint;

class CreateCountriesTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {

            $table->increments('id');
            $table->string('iso2');
			$table->string('iso3');
			$table->string('name');
			$table->string('status');
			//$table->multipolygon('geom', 'GEOMETRY', 4326);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('countries');

    }

}


