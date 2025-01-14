<?php

namespace App\Http\Controllers;

use App\Models\TestDrive;
use App\Models\Car;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestDriveController extends Controller
{
    public function store(Request $request, Car $car)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required'
        ]);

        $existingBooking = TestDrive::where('date', $request->date)
        ->where('time', $request->time)
        ->where('car_id', $car->id)
        ->first();

    if ($existingBooking) {
        return redirect()->back()->with('error', 'This time slot is already booked. Please choose another time.');
    }

        TestDrive::create([
            'car_id' => $car->id,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Test drive request submitted successfully.');
    }

    public function getAvailableTimeSlots($date)
    {
        $bookedSlots = TestDrive::where('date', $date)
            ->pluck('time')
            ->toArray();

        $allTimeSlots = $this->generateTimeSlots();
        $availableSlots = array_diff($allTimeSlots, $bookedSlots);

        return response()->json(array_values($availableSlots));
    }

    private function generateTimeSlots()
    {
        $slots = [];
        $start = strtotime('09:00');
        $end = strtotime('17:00');
        $interval = 60 * 60; // 1 hour intervals

        for ($time = $start; $time <= $end; $time += $interval) {
            $slots[] = date('H:i', $time);
        }

        return $slots;
    }

    public function getAvailableTimes($date)
{
    // Get only approved bookings for this date
    $bookedTimes = TestDrive::where('date', $date)
        ->where('status', 'approved')
        ->pluck('time')
        ->map(fn($time) => $time->format('H:i'))
        ->toArray();

    // Generate time slots from 9 AM to 5 PM
    $availableTimeSlots = [];
    $start = new DateTime('09:00');
    $end = new DateTime('17:00');
    $interval = new DateInterval('PT1H');

    while ($start < $end) {
        $timeSlot = $start->format('H:i');
        $isBooked = in_array($timeSlot, $bookedTimes);
        
        $availableTimeSlots[] = [
            'time' => $timeSlot,
            'available' => !$isBooked,
            'message' => $isBooked ? 'Already booked' : 'Available'
        ];
        
        $start->add($interval);
    }

    return response()->json($availableTimeSlots);
}




}
