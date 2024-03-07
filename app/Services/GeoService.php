<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeoService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('NOMBRE_VARIABLE');
    }

    public function getCountries()
    {
        $response = Http::withHeaders([
            'X-CSCAPI-KEY' => $this->apiKey
        ])->get('https://api.countrystatecity.in/v1/countries');

        return $response->json();
    }

    public function getStates($countryCode)
{
    $response = Http::withHeaders([
        'X-CSCAPI-KEY' => $this->apiKey
    ])->get("https://api.countrystatecity.in/v1/countries/{$countryCode}/states");

    return $response->json();
}

public function getCities($countryCode, $stateCode)
{
    $response = Http::withHeaders([
        'X-CSCAPI-KEY' => $this->apiKey
    ])->get("https://api.countrystatecity.in/v1/countries/{$countryCode}/states/{$stateCode}/cities");

    return $response->json();
}

    
}
