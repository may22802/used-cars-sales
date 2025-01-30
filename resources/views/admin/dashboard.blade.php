<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .tab-btn {
            @apply font-medium text-gray-600 hover:text-gray-900 border-transparent transition-all duration-300;
        }

        .tab-btn.active {
            @apply text-black border-black font-semibold;
        }

        .tab-btn svg {
            @apply transition-transform duration-300;
        }

        .tab-btn:hover svg {
            @apply transform scale-110;
        }


        .tab-content {
            @apply transition-all duration-300;
        }

        .bruno-ace-regular {
            font-family: "Bruno Ace", serif;
            font-weight: 400;
            font-style: normal;
        }
    </style>
</head>

<!-- Main Layout -->
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-lg flex flex-col h-full">
        <!-- Logo -->
        <div class="p-4 border-b">
            <a href="/" class="flex items-center">
                <span class="text-xl font-bold bruno-ace-regular">ABC Car</span>
            </a>
        </div>

        <!-- Top Navigation Items -->
        <div class="py-4">
            <nav class="space-y-1">
                <a href="#" onclick="switchTab(this, 'dashboard')"
                    class="tab-btn flex items-center px-6 py-3 hover:bg-gray-100 border-l-4 {{ request()->get('tab') === 'dashboard' ? 'border-black bg-gray-50' : 'border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span class="{{ request()->get('tab') === 'dashboard' ? 'font-semibold' : '' }}">Dashboard</span>
                </a>

                <a href="#" onclick="switchTab(this, 'profile')"
                    class="tab-btn flex items-center px-6 py-3 hover:bg-gray-100 border-l-4 {{ request()->get('tab') === 'profile' ? 'border-black bg-gray-50' : 'border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="{{ request()->get('tab') === 'profile' ? 'font-semibold' : '' }}">Profile</span>
                </a>
                <a href="#" onclick="switchTab(this, 'users')"
                    class="tab-btn flex items-center px-6 py-3 hover:bg-gray-100 border-l-4 {{ request()->get('tab') === 'users' ? 'border-black bg-gray-50' : 'border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="{{ request()->get('tab') === 'users' ? 'font-semibold' : '' }}">Users</span>
                </a>

                <a href="#" onclick="switchTab(this, 'cars')"
                    class="tab-btn flex items-center px-6 py-3 hover:bg-gray-100 border-l-4 {{ request()->get('tab') === 'cars' ? 'border-black bg-gray-50' : 'border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16v-4m0 0v4m0-4h8m-8 0H6a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2m-8 0V8a2 2 0 012-2h4a2 2 0 012 2v4M6 20h12a2 2 0 002-2v-4a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2z" />
                    </svg>
                    <span class="{{ request()->get('tab') === 'cars' ? 'font-semibold' : '' }}">Active Cars</span>
                </a>

                <a href="#" onclick="switchTab(this, 'sold-cars')"
                    class="tab-btn flex items-center px-6 py-3 hover:bg-gray-100 border-l-4 {{ request()->get('tab') === 'sold-cars' ? 'border-black bg-gray-50' : 'border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    <span class="{{ request()->get('tab') === 'sold-cars' ? 'font-semibold' : '' }}">Sold Cars</span>
                </a>
                <!-- Add this after the "Sold Cars" nav item -->
                <a href="#" onclick="switchTab(this, 'test-drives')"
                    class="tab-btn flex items-center px-6 py-3 hover:bg-gray-100 border-l-4 {{ request()->get('tab') === 'test-drives' ? 'border-black bg-gray-50' : 'border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="{{ request()->get('tab') === 'test-drives' ? 'font-semibold' : '' }}">Test Drive
                        Bookings</span>
                </a>

            </nav>
        </div>

        <!-- Bottom Navigation Items -->
        <div class="mt-auto border-t py-4">
            <nav class="space-y-1">
                <a href="#" class="flex items-center px-6 py-3 hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                </a>
                <a href="#" class="flex items-center px-6 py-3 hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Help Center
                </a>
            </nav>
        </div>
    </div>


    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Header -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-end px-6 py-3">
                <div class="flex items-center space-x-4">
                    <!-- Notification Icon -->
                    <button class="p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>


                    <!-- User Menu -->
                    <div class="relative">
                        <button id="userMenuButton" class="flex items-center space-x-2">
                            <span class="text-gray-700">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- User Dropdown Menu -->
                        <div id="userMenu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                            <!-- Replace the existing logout button with this enhanced version -->
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 font-medium border-t">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </div>
                                </button>
                            </form>

                        </div>
                    </div>

                    <!-- Three Dot Menu -->
                    <button class="p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
            <!-- Your existing tab content here -->
            <!-- Dashboard Tab Content -->
            <div id="dashboard" class="tab-content">
                <!-- Stats Overview -->
                <div class="grid grid-cols-4 gap-6 mb-8">
                    <!-- Total Users -->
                    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 mr-4">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500">Total Users</p>
                                <h3 class="text-2xl font-bold">{{ $users->count() }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Active Cars -->
                    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 mr-4">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 16v-4m0 0v4m0-4h8m-8 0H6a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2m-8 0V8a2 2 0 012-2h4a2 2 0 012 2v4" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500">Active Cars</p>
                                <h3 class="text-2xl font-bold">{{ $cars->count() }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Sold Cars -->
                    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 mr-4">
                                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500">Sold Cars</p>
                                <h3 class="text-2xl font-bold">{{ $soldCars->count() }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Test Drive Bookings -->
                    <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 mr-4">
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500">Test Drive Bookings</p>
                                <h3 class="text-2xl font-bold">{{ $testDrives->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="grid grid-cols-2 gap-6">
                    <!-- Latest Test Drive Bookings -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-bold mb-4">Recent Test Drive Bookings</h3>
                        <div class="space-y-4">
                            @foreach ($testDrives->sortByDesc('created_at')->take(3) as $booking)
                                <div class="flex items-center justify-between border-b pb-2">
                                    <div>
                                        <p class="font-medium">{{ $booking->car->brand }} {{ $booking->car->model }}
                                        </p>
                                        <p class="text-sm text-gray-500">by {{ $booking->user->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm">{{ $booking->date->format('M d, Y') }}</p>
                                        <p class="text-sm">{{ $booking->time->format('h:i A') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Latest Car Sales -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-bold mb-4">Recent Car Sales</h3>
                        <div class="space-y-4">
                            @foreach ($soldCars->sortByDesc('approved_bid.created_at')->take(3) as $car)
                                <div class="flex items-center justify-between border-b pb-2">
                                    <div>
                                        <p class="font-medium">{{ $car->brand }} {{ $car->model }}</p>
                                        <p class="text-sm text-gray-500">to {{ $car->approved_bid->user->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium">${{ number_format($car->approved_bid->amount) }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ $car->approved_bid->updated_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- After Recent Activities -->
                <div class="grid grid-cols-2 gap-6 mt-6">
                    <!-- Sales Overview Chart -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-bold mb-4">Sales Overview</h3>
                        <canvas id="salesChart"></canvas>
                    </div>

                    <!-- Test Drive Statistics Chart -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-bold mb-4">Test Drive Statistics</h3>
                        <canvas id="testDriveChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Profile Tab -->
            <div id="profile" class="tab-content hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-gray-500">
                    <h2 class="text-2xl font-bold mb-6">Admin Profile</h2>
                    <form action="{{ route('admin.profile.update') }}" method="POST"
                        class="grid grid-cols-2 gap-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-gray-700 mb-2">Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}"
                                class="w-full px-4 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}"
                                class="w-full px-4 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Phone</label>
                            <input type="tel" name="phone" value="{{ Auth::user()->phone }}"
                                class="w-full px-4 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Address</label>
                            <input type="text" name="address" value="{{ Auth::user()->address }}"
                                class="w-full px-4 py-2 border rounded">
                        </div>
                        <div class="col-span-2">
                            <button type="submit"
                                class="bg-black text-white px-6 py-2 rounded hover:bg-red-700">Update
                                Profile</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users Tab -->
            <div id="users" class="tab-content hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-gray-500">
                    <h2 class="text-2xl font-bold mb-6">Registered Users</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Phone</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Address</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Joined Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->phone }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->address }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $user->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button
                                                onclick="openStatusModal('{{ $user->id }}', '{{ $user->status }}')"
                                                class="{{ $user->status === 'active' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-4 py-2 rounded-md text-sm">
                                                {{ $user->status === 'active' ? 'Deactivate' : 'Reactivate' }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $users->appends(['tab' => 'users'])->links() }}
                        </div>
                    </div>
                </div>
                <!-- Status Change Confirmation Modal -->
                <div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
                    <div class="bg-white p-8 rounded-lg w-96">
                        <h3 class="text-xl font-bold mb-4">Confirm Status Change</h3>
                        <p id="statusMessage" class="text-gray-600 mb-6"></p>
                        <form id="statusForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="flex justify-end gap-4">
                                <button type="button" onclick="closeStatusModal()"
                                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">
                                    Confirm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Cars Tab -->
            <div id="cars" class="tab-content hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-gray-500">
                    <h2 class="text-2xl font-bold mb-6">Car Posts</h2>
                    <div class="grid grid-cols-4 border border-gray-200">
                        @foreach ($cars as $car)
                            <div class="border border-gray-500 p-4">
                                <!-- Car Image -->
                                <div class="h-40 overflow-hidden border-b border-gray-200">
                                    @if ($car->photos->count() > 0)
                                        <img src="{{ Storage::url($car->photos->first()->photo_path) }}"
                                            alt="{{ $car->brand }} {{ $car->model }}"
                                            class="w-full h-full object-cover">
                                    @endif
                                </div>

                                <!-- Car Details -->
                                <div class="p-3 bg-white">
                                    <div class="mb-3 border-b border-gray-200 pb-2">
                                        <h3 class="text-lg font-bold truncate">{{ $car->brand }}
                                            {{ $car->model }}</h3>
                                        <p class="text-gray-600 text-xs">Posted by: {{ $car->user->name }}</p>
                                    </div>

                                    <div class="space-y-1 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Country:</span>
                                            <span class="font-medium">{{ $car->country }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Fuel:</span>
                                            <span class="font-medium">{{ $car->fuel }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Year:</span>
                                            <span class="font-medium">{{ $car->year }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Price:</span>
                                            <span class="font-medium">${{ number_format($car->price) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Mileage:</span>
                                            <span class="font-medium">{{ number_format($car->meter_usage) }} KM</span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-3 grid grid-cols-3 border-t border-gray-200 pt-2">
                                        <button onclick="openEditModal({{ $car->id }})"
                                            class="border-r border-gray-200 py-1.5 text-sm font-medium hover:bg-gray-50">
                                            Edit
                                        </button>
                                        <button
                                            onclick="openCarStatusModal('{{ $car->id }}', '{{ $car->status }}')"
                                            class="{{ $car->status === 'active' ? 'text-red-600' : 'text-green-600' }} border-r border-gray-200 py-1.5 text-sm font-medium hover:bg-gray-50">
                                            {{ $car->status === 'active' ? 'Deactivate' : 'Reactivate' }}
                                        </button>
                                        <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this car post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full py-1.5 text-sm font-medium text-red-600 hover:bg-gray-50 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sold Cars Tab -->
            <div id="sold-cars" class="tab-content hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-gray-500">
                    <h2 class="text-2xl font-bold mb-6">Sold Cars</h2>
                    <div class="grid grid-cols-4 border border-gray-200">
                        @foreach ($soldCars as $car)
                            <div class="border border-gray-500 p-4">
                                <!-- Car Image -->
                                <div class="h-40 overflow-hidden border-b border-gray-200">
                                    @if ($car->photos->count() > 0)
                                        <img src="{{ Storage::url($car->photos->first()->photo_path) }}"
                                            alt="{{ $car->brand }} {{ $car->model }}"
                                            class="w-full h-full object-cover">
                                    @endif
                                </div>

                                <!-- Car Details -->
                                <div class="p-3 bg-white">
                                    <div class="mb-3 border-b border-gray-200 pb-2">
                                        <h3 class="text-lg font-bold truncate">{{ $car->brand }}
                                            {{ $car->model }}</h3>
                                        <p class="text-gray-600 text-xs">Sold by: {{ $car->user->name }}</p>
                                        <p class="text-gray-600 text-xs">Sold to: {{ $car->approved_bid->user->name }}
                                        </p>
                                    </div>

                                    <div class="space-y-1 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Sold Price:</span>
                                            <span
                                                class="font-medium">${{ number_format($car->approved_bid->amount) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Sold Date:</span>
                                            <span
                                                class="font-medium">{{ $car->approved_bid->updated_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Original Price:</span>
                                            <span class="font-medium">${{ number_format($car->price) }}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Test Drive Bookings Tab -->
            <div id="test-drives" class="tab-content hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-gray-500">
                    <h2 class="text-2xl font-bold mb-6">Test Drive Booking Management</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Car</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Requested By</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Time</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($testDrives as $booking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if ($booking->car->photos->count() > 0)
                                                    <img src="{{ Storage::url($booking->car->photos->first()->photo_path) }}"
                                                        alt="Car" class="w-10 h-10 rounded-full object-cover">
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $booking->car->brand }} {{ $booking->car->model }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $booking->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $booking->date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $booking->time->format('h:i A') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 py-1 text-xs rounded-full
                                    @if ($booking->status === 'approved') bg-green-100 text-green-800
                                    @elseif($booking->status === 'denied') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($booking->status === 'pending')
                                                <form action="{{ route('admin.test-drives.update', $booking->id) }}"
                                                    method="POST" class="flex space-x-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" name="status" value="approved"
                                                        class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600">
                                                        Approve
                                                    </button>
                                                    <button type="submit" name="status" value="denied"
                                                        class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">
                                                        Deny
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <!-- Edit Car Modal -->
            <div id="editCarModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center ">
                <div class="bg-white p-8 rounded-lg w-full max-w-2xl">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Edit Car Details</h2>
                        <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form id="editCarForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 mb-2">Brand</label>
                                <input type="text" name="brand" id="edit_brand"
                                    class="w-full px-4 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Model</label>
                                <input type="text" name="model" id="edit_model"
                                    class="w-full px-4 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Country Make</label>
                                <input type="text" name="country" id="edit_country"
                                    class="w-full px-4 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Fuel Type</label>
                                <select name="fuel" id="edit_fuel" class="w-full px-4 py-2 border rounded">
                                    <option value="petrol">Petrol</option>
                                    <option value="diesel">Diesel</option>
                                    <option value="electric">Electric</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Registration Year</label>
                                <input type="number" name="year" id="edit_year"
                                    class="w-full px-4 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Price (USD)</label>
                                <input type="number" name="price" id="edit_price"
                                    class="w-full px-4 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Meter Usage (KM)</label>
                                <input type="number" name="meter_usage" id="edit_meter_usage"
                                    class="w-full px-4 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Car Photos</label>
                                <input type="file" name="photos[]" multiple
                                    class="w-full px-4 py-2 border rounded" accept="image/*">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="closeEditModal()"
                                class="mr-4 px-4 py-2 text-gray-500 hover:text-gray-700">Cancel</button>
                            <button type="submit" class="bg-black text-white px-6 py-2 rounded ">Update Car</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="carStatusModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
                <div class="bg-white p-8 rounded-lg w-96">
                    <h3 class="text-xl font-bold mb-4">Confirm Car Status Change</h3>
                    <p id="carStatusMessage" class="text-gray-600 mb-6"></p>
                    <form id="carStatusForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="flex justify-end gap-4">
                            <button type="button" onclick="closeCarStatusModal()"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">
                                Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    function switchTab(element, tabName) {
        const tabs = document.querySelectorAll('.tab-content');
        const buttons = document.querySelectorAll('.tab-btn');

        tabs.forEach(tab => tab.classList.add('hidden'));
        buttons.forEach(btn => {
            btn.classList.remove('border-black', 'bg-gray-50');
            btn.classList.add('border-transparent');
            btn.querySelector('span').classList.remove('font-semibold');
        });

        document.getElementById(tabName).classList.remove('hidden');
        element.classList.remove('border-transparent');
        element.classList.add('border-black', 'bg-gray-50');
        element.querySelector('span').classList.add('font-semibold');

        const url = new URL(window.location);
        url.searchParams.set('tab', tabName);
        window.history.pushState({}, '', url);
    }
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('tab') || 'dashboard';
        const tabButton = document.querySelector(`[onclick*="switchTab(this, '${activeTab}')"]`);
        if (tabButton) {
            switchTab(tabButton, activeTab);
        }
    });

    function openStatusModal(userId, currentStatus) {
        const modal = document.getElementById('statusModal');
        const message = document.getElementById('statusMessage');
        const form = document.getElementById('statusForm');

        form.action = `/admin/users/${userId}/toggle-status`;
        message.textContent = currentStatus === 'active' ?
            'Are you sure you want to deactivate this user?' :
            'Are you sure you want to reactivate this user?';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeStatusModal() {
        const modal = document.getElementById('statusModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openEditModal(carId) {
        const cars = @json($cars);
        const selectedCar = cars.find(c => c.id === carId);

        document.getElementById('editCarForm').action = `/admin/cars/${carId}`;
        document.getElementById('edit_brand').value = selectedCar.brand;
        document.getElementById('edit_model').value = selectedCar.model;
        document.getElementById('edit_country').value = selectedCar.country;
        document.getElementById('edit_fuel').value = selectedCar.fuel;
        document.getElementById('edit_year').value = selectedCar.year;
        document.getElementById('edit_price').value = selectedCar.price;
        document.getElementById('edit_meter_usage').value = selectedCar.meter_usage;
        document.getElementById('editCarModal').classList.remove('hidden');
        document.getElementById('editCarModal').classList.add('flex');
    }


    function closeEditModal() {
        document.getElementById('editCarModal').classList.add('hidden');
        document.getElementById('editCarModal').classList.remove('flex');
    }

    function openCarStatusModal(carId, currentStatus) {
        const modal = document.getElementById('carStatusModal');
        const message = document.getElementById('carStatusMessage');
        const form = document.getElementById('carStatusForm');

        form.action = `/admin/cars/${carId}/toggle-status`;
        message.textContent = currentStatus === 'active' ?
            'Are you sure you want to deactivate this car post?' :
            'Are you sure you want to reactivate this car post?';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCarStatusModal() {
        const modal = document.getElementById('carStatusModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('userMenuButton').addEventListener('click', function() {
        document.getElementById('userMenu').classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userMenu');
        const button = document.getElementById('userMenuButton');
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
    // Sales Chart - Weekly Data
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Weekly Car Sales',
                data: [
                    @foreach ($weeklySales as $week => $count)
                        {{ $count }},
                    @endforeach
                ],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Weekly Sales Overview'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Test Drive Chart
    const testDriveCtx = document.getElementById('testDriveChart').getContext('2d');
    new Chart(testDriveCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Approved', 'Denied'],
            datasets: [{
                data: [
                    {{ $testDrives->where('status', 'pending')->count() }},
                    {{ $testDrives->where('status', 'approved')->count() }},
                    {{ $testDrives->where('status', 'denied')->count() }}
                ],
                backgroundColor: [
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(255, 99, 132)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>
</body>

</html>
