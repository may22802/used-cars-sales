<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'fuel' => 'required|string|in:petrol,diesel,electric,hybrid',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'meter_usage' => 'required|integer|min:0',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $car = Car::create([
            'user_id' => Auth::id(),
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'country' => $validated['country'],
            'fuel' => $validated['fuel'],
            'year' => $validated['year'],
            'meter_usage' => $validated['meter_usage'],
            'price' => $validated['price'],
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('car-photos', 'public');
                CarPhoto::create([
                    'car_id' => $car->id,
                    'photo_path' => $path
                ]);
            }
        }

        return redirect()->back()->with('success', 'Car listed successfully');
    }

    public function getUserCars()
    {
        $cars = Car::with('photos')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return response()->json($cars);
    }
}
