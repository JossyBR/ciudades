<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CityService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENWEATHER_API_KEY');
    }

    public function getWeatherByCityName($cityName, $countryCode)
    {
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$cityName},{$countryCode}&appid={$this->apiKey}&units=metric";

        $response = Http::get($url);

        return $response->successful() ? $response->json() : null;
    }
}
