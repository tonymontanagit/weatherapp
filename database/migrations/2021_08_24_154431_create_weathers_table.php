<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeathersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('weathers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('city_id')->unsigned();
            $table->string('weather_main');
            $table->string('weather_description');
            $table->string('weather_icon');
            $table->float('main_temp');
            $table->float('main_feels_like');
            $table->float('main_temp_min');
            $table->float('main_temp_max');
            $table->float('main_pressure');
            $table->float('main_humidity');
            $table->integer('visibility');
            $table->float('wind_speed');
            $table->integer('wind_deg');
            $table->integer('clouds_all');
            $table->timestamp('time_of_data_calculation')->nullable();
            $table->timestamps();
            $table->foreign('city_id')
                    ->references('id')
                    ->on('cities')
                    ->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weathers');
    }
}
