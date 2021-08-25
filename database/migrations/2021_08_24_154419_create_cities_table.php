<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('state_code')->nullable();
            $table->string('country_code')->nullable();
            $table->timestamps();
        });

        $cities = config('weather_cities.cities');
  
        if(is_array($cities)){
            foreach ($cities as $city) {
                try {
                    DB::table('cities')->insert(
                        array(
                            'name' => $city['name'],
                            'state_code' => $city['state_code'],
                            'country_code' => $city['country_code'],
                            'created_at' => Carbon::now()
                        )
                    );
                } catch(QueryException $ex){ 
                    Log::error($ex->getMessage());
                }
            }
        }else{
            echo "Cities list is empty. Check configuration file: ./config/weather_cities.php";
            Log::error("Cities list is empty. Check configuration file: ./config/weather_cities.php");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
