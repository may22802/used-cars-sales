<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function store(Request $request, Car $car)
    {
        $request->validate([
            'amount' => ['required', 'numeric', "min:{$car->price}"]
        ]);

        Bid::create([
            'car_id' => $car->id,
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Bid placed successfully!');
    }
}
