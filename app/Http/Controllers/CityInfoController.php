<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CityInfoController extends Controller
{
    public function index()
    {
        return view('info-city');
    }
}
