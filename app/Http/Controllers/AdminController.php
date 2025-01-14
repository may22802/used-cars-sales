<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Notification as ModelsNotification;
use App\Models\TestDrive;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $activeTab = request('tab', 'profile');

            $users = User::where('role', 'user')
                ->latest()
                ->paginate(10, ['*'], 'users_page');

                $cars = Car::with(['photos', 'user'])
                ->whereDoesntHave('bids', function($query) {
                    $query->where('status', 'approved');
                })
                ->latest()
                ->get();
            

            $soldCars = Car::with(['photos', 'approved_bid.user'])
                ->whereHas('bids', function ($query) {
                    $query->where('status', 'approved');
                })
                ->latest()
                ->get();

                $testDrives = TestDrive::with(['car.photos', 'user'])->latest()->get();

                

                $weeklySales = Car::whereHas('approved_bid')
                ->selectRaw('COUNT(*) as count, WEEK(created_at) as week')
                ->groupBy('week')
                ->pluck('count', 'week')
                ->toArray();
            return view('admin.dashboard', compact('users', 'cars', 'activeTab', 'soldCars','testDrives','weeklySales'));
        } else {
            abort(403, 'Unauthorized');
        }
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

    public function updateTestDriveStatus(Request $request, TestDrive $testDrive)
{
    $request->validate([
        'status' => 'required|in:approved,denied'
    ]);

    $testDrive->update([
        'status' => $request->status
    ]);

    // Create notification
    $message = $request->status === 'approved' 
        ? "Your test drive booking for {$testDrive->car->brand} {$testDrive->car->model} on {$testDrive->date->format('M d, Y')} at {$testDrive->time->format('h:i A')} has been approved."
        : "Your test drive booking for {$testDrive->car->brand} {$testDrive->car->model} has been denied. Please try booking another time slot.";

    ModelsNotification::create([
        'user_id' => $testDrive->user_id,
        'message' => $message,
        'read_at' => null
    ]);

    return redirect()->back()->with('success', 'Test drive status updated successfully');
}



}
