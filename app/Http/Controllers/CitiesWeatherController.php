<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Repositories\CityRepository;
use App\Services\WeatherService;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Log;

class CitiesWeatherController extends Controller
{
    /**
     * @var $cityRepository
     */
    private $cityRepository;

    private $weatherService;

    /**
     * CitiesWeatherController Constructor
     *
     * @param WeatherService $weatherService
     *
     */
    public function __construct(WeatherService $weatherService, CityRepository $cityRepository)
    {
        $this->weatherService = $weatherService;
        $this->cityRepository = $cityRepository;
    }

    public function saveAllCitiesWeather()
    {
        $client = new Client();

        $allCities = $this->cityRepository->getAll();       

        if($allCities->isNotEmpty()){
            foreach ($allCities as $city) {
                
                $qParam = $city->name;
                if(!empty($city->state_code)) $qParam .= ','.$city->state_code;
                if(!empty($city->country_code)) $qParam .= ','.$city->country_code;

                try{
                    $res = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather', [
                        'query' => [
                            'q' => $qParam,
                            'appid' => config('weather_cities.apikey')
                        ]
                    ]);

                    if ($res->getStatusCode() == 200) { // 200 OK
                        $response_data = $res->getBody()->getContents();
                        try{
                            $this->weatherService->saveCityWeatherData($response_data, $city->id, $city->name);
                        }
                        catch(Exception $e){
                            Log::error($e->getMessage());
                        }
                    }
                }
                catch (ConnectException $e) {
                    Log::error("Internet, DNS, or other connection error\n");
                }
                catch (RequestException $e) {
                    
                    $error['error'] = $e->getMessage();

                    if($e->hasResponse()){
                        $error['response'] = $e->getResponse();
                        if ($e->getResponse()->getStatusCode() == '401'){                            
                            $error['info'] = "Authorization failed. Check API Key validity";
                        }
                    }
                    Log::error("Error occurred in get request.", ['error' => $error]);
                }
            }    
                    
            $date_time = date("d-m-Y (D) H:i:s", time());
            echo 'weather data saved successfully on '. $date_time;
            Log::channel('weather_data')->info('weather data saved successfully on '. $date_time);
        }else{
            echo 'Cities list is empty. ';
            Log::error("Cities list is empty.\n");
        }
    }
}
