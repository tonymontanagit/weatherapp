<?php

namespace App\Services;

// use App\Models\Weather;
// use App\Models\City;
use App\Repositories\CityRepository;
use App\Repositories\WeatherRepository;
use Exception;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class WeatherService
{
    /**
     * @var $weatherRepository
     */
    protected $weatherRepository;

    /**
     * @var $cityRepository
     */
    protected $cityRepository;

    /**
     * PostService constructor.
     *
     * @param WeatherRepository $weatherRepository
     */
    public function __construct(WeatherRepository $weatherRepository,
                                CityRepository $cityRepository)
    {
        $this->weatherRepository = $weatherRepository;
        $this->cityRepository = $cityRepository;
    }

    /**
     * Validate post data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function saveCityWeatherData($data, $cityId, $cityName)
    {
        $dataArray = (array)json_decode((string)$data, true);

        $validator = Validator::make($dataArray, $this->weatherDataValidatorRules());

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        if($dataArray['name'] == $cityName && $this->cityRepository->getById($cityId)->isNotEmpty()){           
            $result = $this->weatherRepository->saveByCityId($dataArray, $cityId);
        }
             
        return $result;
    }

    protected function weatherDataValidatorRules(){
        return [                       
            'coord.lon' => 'required|numeric',
            'coord.lat' => 'required|numeric',
            'weather.*.main' => 'required|string',
            'weather.*.description' => 'required|string', 
            'weather.*.icon' => 'required|string',    
            'main.temp' => 'required|numeric',
            'main.feels_like' => 'required|numeric',
            'main.temp_min' => 'required|numeric',
            'main.temp_max' => 'required|numeric',
            'main.pressure' => 'required|numeric',
            'main.humidity' => 'required|numeric',
            'visibility' => 'required|numeric',
            'wind.speed' => 'required|numeric',
            'wind.deg' => 'required|numeric',
            'clouds.all' => 'required|numeric',
            'name' => 'required|string',
            'dt' => 'required|numeric'
        ];
    }
}