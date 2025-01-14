<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $brands = Car::distinct()->pluck('brand');
        $models = Car::distinct()->pluck('model');
        $years = Car::distinct()->orderBy('year', 'desc')->pluck('year');
        $countries = Car::distinct()->pluck('country');
        $fuelTypes = Car::distinct()->pluck('fuel');

        return view('home', compact('brands', 'models', 'years', 'countries', 'fuelTypes'));
    }
}

