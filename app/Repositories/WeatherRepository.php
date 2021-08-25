<?php

namespace App\Repositories;

use App\Models\Weather;
use Carbon\Carbon;

class WeatherRepository
{
    /**
     * @var Weather
     */
    protected $weather;

    /**
     * WeatherRepository constructor.
     *
     * @param Weather $weather
     */
    public function __construct(Weather $weather)
    {
        $this->weather = $weather;
    }

    /**
     * Get all weathers.
     *
     * @return Weather $weather
     */
    public function getAll()
    {
        return $this->weather
            ->get();
    }

    /**
     * Get weather by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->weather
            ->where('id', $id)
            ->get();
    }


    /**
     * Save Weather
     *
     * @param $data
     * @return Weather
     */
    public function saveByCityId($data, $cityId)
    {
        $weather = $this->mapToModel($data, $cityId);

        $weather->save();

        return $weather->fresh();
    }

    private function mapToModel($data, $cityId){

        $weather = new $this->weather;

        $weather->city_id = $cityId;
        $weather->weather_main = $data['weather'][0]['main'];
        $weather->weather_description = $data['weather'][0]['description'];
        $weather->weather_icon = $data['weather'][0]['icon'];
        $weather->main_temp = $data['main']['temp'];
        $weather->main_feels_like = $data['main']['feels_like'];
        $weather->main_temp_min = $data['main']['temp_min'];
        $weather->main_temp_max = $data['main']['temp_max'];
        $weather->main_pressure = $data['main']['pressure'];
        $weather->main_humidity = $data['main']['humidity'];
        $weather->visibility = $data['visibility'];
        $weather->wind_speed = $data['wind']['speed'];
        $weather->wind_deg = $data['wind']['deg'];
        $weather->clouds_all = $data['clouds']['all'];
        $weather->time_of_data_calculation = Carbon::createFromTimestamp($data['dt']);

        return $weather;
    }

    /**
     * Update weather
     *
     * @param $data
     * @return weather
     */
    public function update($data, $id)
    {       
        $weather = $this->weather->find($id);

        $weather->title = $data['title'];
        $weather->description = $data['description'];

        $weather->update();

        return $weather;
    }

}