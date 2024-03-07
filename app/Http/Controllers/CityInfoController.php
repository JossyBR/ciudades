<?php

namespace App\Http\Controllers;
use App\Services\GeoService;
use App\Services\CityService;
use App\Models\City;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;



use Illuminate\Http\Request;

class CityInfoController extends Controller
{

    protected $geoService;

    public function __construct(GeoService $geoService)
    {
        $this->geoService = $geoService;
    }

    public function index()
    {
        $countries = $this->geoService->getCountries();

        return view('info-city', compact('countries'));
    }

    // Método para obtener los estados basados en el código de país
    public function getStates(Request $request, $countryCode)
    {
        $states = $this->geoService->getStates($countryCode);
        return response()->json($states);
    }

    // Método para obtener las ciudades basadas en el código de país y estado
    public function getCities(Request $request, $countryCode, $stateCode)
    {
        $cities = $this->geoService->getCities($countryCode, $stateCode);
        return response()->json($cities);
    }

    // public function index()
    // {
    //     $client = new Client();

    //     $response = $client->request('GET', 'https://api.countrystatecity.in/v1/countries', [
    //         'headers' => [
    //             'X-CSCAPI-KEY' => env('NOMBRE_VARIABLE')
    //         ]
    //     ]);

    //     $countries = json_decode($response->getBody()->getContents());

    //     return view('info-city', compact('countries'));
    // }


    //Para busqueda y guardado de las ciudades
    // public function getCityInfo(Request $request, CityService $cityService)
    // {
    //     $cityName = $request->input('city');
    //     $countryCode = $request->input('country');
    
    //     $cityInfo = $cityService->getCityInfo($cityName, $countryCode);
    
    //     if ($cityInfo) {
    //         return view('info-city', compact('cityInfo'));
    //     } else {
    //         return back()->with('error', 'No se encontraron resultados para la ciudad especificada.');
    //     }
    // }

    public function getCityWeather(Request $request, CityService $weatherService)
    {
        $cityName = $request->input('city');
        $countryCode = $request->input('country');
    
        $weatherInfo = $weatherService->getWeatherByCityName($cityName, $countryCode);
    
        if (!empty($weatherInfo)) {
            return view('info-city', compact('weatherInfo'));
        } else {
            return back()->with('error', 'No se pudo obtener la información meteorológica.');
        }
    }

    



//     public function getCityInfo(Request $request)
// {
//     $cityName = $request->input('city');
//     $countryCode = $request->input('country');
//     $response = Http::withHeaders([
//         'X-Api-Key' => env('API_NINJA_KEY')
//     ])->get("https://api.api-ninjas.com/v1/city?name={$cityName}&country={$countryCode}");

//     $data = $response->json();
//     // dd($response->json());


//     if ($response->successful() && !empty($data)) {
//         $cityInfo = $data[0];
//         return view('info-city', compact('cityInfo'));
//     } else {
//         // Puedes decidir si mostrar un mensaje de error o simplemente indicar que no se encontraron resultados.
//         return back()->with('error', 'No se encontraron resultados para la ciudad especificada.');
//     }
// }


public function saveCityInfo(Request $request)
    {
        // Validar los datos del formulario
        $data = $request->validate([
            'name' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'country' => 'required|string',
            'population' => 'required|integer',
            'is_capital' => 'required|boolean',
        ]);

        // Guardar en la base de datos
        $city = new City($data);
        $city->save();

        // Redirigir al usuario con un mensaje de éxito
        return redirect()->route('info-city')->with('success', 'Información de la ciudad guardada con éxito.');
    }

// public function saveCityInfo(Request $request)
// {
//     // Asume que recibes todos los datos necesarios de la ciudad como parte del request
//     $city = new City([
//         'name' => $request->name,
//         'latitude' => $request->latitude,
//         'longitude' => $request->longitude,
//         'country' => $request->country,
//         'population' => $request->population,
//         'is_capital' => $request->is_capital === 'true' ? true : false,
//     ]);
//     $city->save();

//     return back()->with('success', 'Información de la ciudad guardada con éxito');
// }


}
