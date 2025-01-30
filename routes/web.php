<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarListingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestDriveController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/car-listing', [CarListingController::class, 'index'])->name('car-listing');
Route::get('/cars/{id}', [CarListingController::class, 'show'])->name('cars.show');

// Bid routes
Route::post('/cars/{car}/bids', [BidController::class, 'store'])->name('bids.store');

// Test drive routes
Route::post('/cars/{car}/test-drives', [TestDriveController::class, 'store'])->name('test-drives.store');
Route::get('/api/available-times/{date}', [TestDriveController::class, 'getAvailableTimeSlots']);


Route::get('/dashboard', function () {
    if(Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }else{
        return redirect()->route('user.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::put('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/admin/cars/{car}', [AdminController::class, 'updateCar'])->name('admin.cars.update');
    Route::delete('/admin/cars/{car}', [AdminController::class, 'destroyCar'])->name('admin.cars.destroy');
    Route::put('/admin/test-drives/{testDrive}', [AdminController::class, 'updateTestDriveStatus'])->name('admin.test-drives.update');
    Route::put('/admin/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
    Route::put('/admin/cars/{car}/toggle-status', [AdminController::class, 'toggleCarStatus'])->name('admin.cars.toggle-status');
    Route::get('/dashboard/member', [UserController::class, 'index'])->name('user.dashboard');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/cars/store', [CarController::class, 'store'])->name('user.cars.store');
    Route::get('/cars/user', [CarController::class, 'getUserCars'])->name('user.cars.list');
    Route::put('/user/cars/{car}', [UserController::class, 'updateCar'])->name('user.cars.update');
    Route::delete('/user/cars/{car}', [UserController::class, 'destroyCar'])->name('user.cars.destroy');
    Route::put('/user/bids/{bid}', [UserController::class, 'updateBidStatus'])->name('user.bids.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
