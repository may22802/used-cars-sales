<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        // Show appropriate cars based on user status
        if (Auth::check() && Auth::user()->role !== 'admin') {
            $query->where('user_id', '!=', Auth::id());
        }

        // Add status filter for active cars only
        $query->where('status', 'active');

        // Add relationships after the where clause
        $query = $query->with(['photos', 'user']);

        // Apply filters
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'LIKE', "%{$search}%")
                    ->orWhere('model', 'LIKE', "%{$search}%");
            });
        }


        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('model')) {
            $query->where('model', $request->model);
        }

        if ($request->filled('fuel')) {
            $query->where('fuel', $request->fuel);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Get unique brands and models
        $brands = Car::distinct()->pluck('brand');
        $models = Car::distinct()->pluck('model');
        $years = Car::distinct()->orderBy('year', 'desc')->pluck('year');
        // $cars = Car::with(['photos', 'approved_bid'])->latest()->paginate(12);
        $cars = $query->latest()->paginate(12);

        // Debug the query


        return view('car-listing', compact('cars', 'brands', 'models', 'years'));
    }


    public function show($id)
    {
        $car = Car::with(['photos', 'user'])->findOrFail($id);
        $totalCars = Car::count();
        return view('cars.show', compact('car', 'totalCars'));
    }
}
