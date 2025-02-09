<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Car;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
{
    if (Auth::user()->role === 'user') {
        // Get active cars (not sold)
        $cars = Car::with('photos')
            ->where('user_id', Auth::id())
            ->whereDoesntHave('bids', function($query) {
                $query->where('status', 'approved');
            })
            ->latest()
            ->get();

        // Get sold cars
        $soldCars = Car::with(['photos', 'approved_bid.user'])
            ->where('user_id', Auth::id())
            ->whereHas('bids', function($query) {
                $query->where('status', 'approved');
            })
            ->latest()
            ->get();

        $myBids = Bid::with(['car', 'car.photos'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $receivedBids = Bid::with(['user', 'car'])
            ->whereIn('car_id', $cars->pluck('id'))
            ->latest()
            ->get();

        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.dashboard', compact('cars', 'soldCars', 'myBids', 'receivedBids','notifications'));
    } else {
        abort(403, 'Unauthorized');
    }
}


    public function updateBidStatus(Request $request, Bid $bid)
    {
         $request->validate([
              'status' => 'required|in:approved,denied'
         ]);

         // Verify the bid belongs to user's car
         if ($bid->car->user_id !== Auth::id()) {
              abort(403, 'Unauthorized');
         }

         $bid->update(['status' => $request->status]);

         return redirect()->back()->with('success', 'Bid status updated successfully');
    }

     public function updateProfile(Request $request)
     {
          $validated = $request->validate([
               'name' => ['required', 'string', 'max:255'],
               'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
               'phone' => ['required', 'string', 'max:20'],
               'address' => ['required', 'string', 'max:255'],
          ]);

          $user = User::find(Auth::id());
          $user->fill($validated);
          $user->save();

          return redirect()->back()->with('success', 'Profile updated successfully');
     }

     public function updateCar(Request $request, Car $car)
     {
         $validated = $request->validate([
             'brand' => 'required|string|max:255',
             'model' => 'required|string|max:255',
             'country' => 'required|string|max:255',
             'fuel' => 'required|string|in:petrol,diesel,electric,hybrid',
             'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
             'price' => 'required|numeric|min:0',
             'meter_usage' => 'required|integer|min:0',
             'photos.*' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048'
         ]);
 
         $car->update($validated);
 
         if ($request->hasFile('photos')) {
             foreach ($car->photos as $photo) {
                 Storage::disk('public')->delete($photo->photo_path);
                 $photo->delete();
             }
 
             foreach ($request->file('photos') as $photo) {
                 $path = $photo->store('car-photos', 'public');
                 $car->photos()->create(['photo_path' => $path]);
             }
         }
 
         return redirect()->back()->with('success', 'Car updated successfully');
     }
 
     public function destroyCar(Car $car)
     {
         foreach ($car->photos as $photo) {
             Storage::disk('public')->delete($photo->photo_path);
         }
         
         $car->delete();
 
         return redirect()->back()->with('success', 'Car deleted successfully');
     }
}
