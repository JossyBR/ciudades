<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CityInfoController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/info-city', [App\Http\Controllers\CityInfoController::class, 'index'])->name('info-city')->middleware('auth');

// Rutas AJAX para obtener estados y ciudades
Route::get('/states/{countryCode}', [CityInfoController::class, 'getStates'])->middleware('auth');
Route::get('/cities/{countryCode}/{stateCode}', [CityInfoController::class, 'getCities'])->middleware('auth');

Route::post('/get-city-info', [CityInfoController::class, 'getCityInfo'])->name('get-city-info')->middleware('auth');

Route::post('/save-city-info', [CityInfoController::class, 'saveCityInfo'])->name('save-city-info')->middleware('auth');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
