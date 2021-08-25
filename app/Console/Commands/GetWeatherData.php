<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App;
use App\Http\Controllers\CitiesWeatherController;

class GetWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:weather_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get weather data from external api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\CitiesWeatherController');
        app()->call([$controller, 'saveAllCitiesWeather'], []);

        return 0;
    }
}
