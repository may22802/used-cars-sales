<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Car Listing</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bruno-ace-regular {
            font-family: "Bruno Ace", serif;
            font-weight: 400;
            font-style: normal;
            color: #1a1a1a;
            font-size: 1.8rem;
        }

        /* Navigation styling */
        header {
            position: absolute;
            background: transparent;
            width: 100%;
            z-index: 50;
        }

        header nav a {
            color: #1a1a1a;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        header nav a:hover {
            transform: translateY(-1px);
        }

        /* Auth buttons styling */
        .auth-button {
            background: linear-gradient(to right, #1a1a1a, #333333);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }

        .auth-button:hover {
            background: linear-gradient(to right, #333333, #4a4a4a);
            transform: translateY(-1px);
        }
    </style>

</head>

<body class="bg-gray-100">
    <!-- Header Section -->
    <header class="w-full z-50 absolute">
        <nav class="container mx-auto px-6 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <span class="ml-3 text-2xl font-bold bruno-ace-regular text-gray-900">ABC Car</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-12">
                    <a href="{{ url('/#about') }}"
                        class="text-gray-900 font-semibold text-lg hover:text-black">About</a>
                    <a href="{{ url('/#contact') }}"
                        class="text-gray-900 font-semibold text-lg hover:text-black">Contact</a>
                    <a href="/car-listing" class="text-gray-900 font-semibold text-lg hover:text-black">Car Listing</a>

                    @auth
                        <div class="relative">
                            <button id="userMenuButton" class="flex items-center space-x-2 text-gray-900">
                                <div
                                    class="border-2 border-gray-900 rounded-full w-[45px] h-[45px] flex items-center justify-center">
                                    <span class="text-lg text-gray-900">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <span class="text-gray-900 font-semibold">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div id="userMenu"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                @else
                                    <a href="{{ route('user.dashboard') }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-900 font-semibold text-lg hover:text-black">Login</a>
                        <a href="{{ route('register') }}"
                            class="bg-gray-900 text-white px-6 py-2 rounded-md hover:bg-black font-semibold">Join us</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>



    <!-- Main Content Section -->
    <div class="container mx-auto px-4 pt-24 pb-8">
        <div class="flex gap-6">
            <!-- Left Side - Filters -->
            <!-- Left Side - Filters -->
            <div class="w-1/4">
                <form action="{{ route('car-listing') }}" method="GET" class="bg-white p-4 rounded-lg shadow-lg">
                    <div class="grid grid-cols-2 gap-5">
                        <!-- Search -->
                        <div class="col-span-2">
                            <label class="block text-gray-700 text-sm">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full px-2 py-2 text-sm border rounded" placeholder="Search by brand, model...">
                        </div>

                        <!-- Brand -->
                        <div>
                            <label class="block text-gray-700 text-sm">Brand</label>
                            <select name="brand" class="w-full px-2 py-1 text-sm border rounded">
                                <option value="">All Brands</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand }}"
                                        {{ request('brand') == $brand ? 'selected' : '' }}>
                                        {{ $brand }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Model -->
                        <div>
                            <label class="block text-gray-700 text-sm">Model</label>
                            <select name="model" class="w-full px-2 py-1 text-sm border rounded">
                                <option value="">All Models</option>
                                @foreach ($models as $model)
                                    <option value="{{ $model }}"
                                        {{ request('model') == $model ? 'selected' : '' }}>
                                        {{ $model }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fuel Type -->
                        <div>
                            <label class="block text-gray-700 text-sm">Fuel Type</label>
                            <select name="fuel" class="w-full px-2 py-1 text-sm border rounded">
                                <option value="">All Types</option>
                                <option value="petrol" {{ request('fuel') == 'petrol' ? 'selected' : '' }}>Petrol
                                </option>
                                <option value="diesel" {{ request('fuel') == 'diesel' ? 'selected' : '' }}>Diesel
                                </option>
                                <option value="electric" {{ request('fuel') == 'electric' ? 'selected' : '' }}>Electric
                                </option>
                                <option value="hybrid" {{ request('fuel') == 'hybrid' ? 'selected' : '' }}>Hybrid
                                </option>
                            </select>
                        </div>

                        <!-- Year -->
                        <div>
                            <label class="block text-gray-700 text-sm">Year</label>
                            <select name="year" class="w-full px-2 py-1 text-sm border rounded">
                                <option value="">All Years</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}"
                                        {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-gray-700 text-sm">Min Price</label>
                            <input type="number" name="min_price" value="{{ request('min_price') }}"
                                class="w-full px-2 py-1 text-sm border rounded" placeholder="Min">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm">Max Price</label>
                            <input type="number" name="max_price" value="{{ request('max_price') }}"
                                class="w-full px-2 py-1 text-sm border rounded" placeholder="Max">
                        </div>

                        <!-- Buttons -->
                        <button type="submit"
                            class="w-full bg-black text-white px-4 py-2 rounded hover:bg-gray-800 text-sm">
                            Search Cars
                        </button>
                        <a href="{{ route('car-listing') }}"
                            class="w-full bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 text-center text-sm">
                            Clear Filters
                        </a>
                    </div>
                </form>
            </div>


            <!-- Right Side - Car Grid -->
            <div class="w-3/4">


                <div class="grid grid-cols-4">
                    @foreach ($cars as $car)
                        <div class="border border-black p-4 relative">
                            <!-- Add status badge -->
                            @if ($car->approved_bid)
                                <div
                                    class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-sm">
                                    Sold Out
                                </div>
                            @else
                                <div
                                    class="absolute top-2 right-2 bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                                    Available
                                </div>
                            @endif

                            <div class="h-40 overflow-hidden">
                                @if ($car->photos->count() > 0)
                                    <img src="{{ Storage::url($car->photos->first()->photo_path) }}"
                                        alt="{{ $car->brand }} {{ $car->model }}"
                                        class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="space-y-2 mt-3">
                                <h3 class="text-lg font-bold">{{ $car->brand }} {{ $car->model }}</h3>
                                <div class="text-sm text-gray-600 space-y-2">
                                    <p>Year: {{ $car->year }}</p>
                                    <p>Fuel: {{ ucfirst($car->fuel) }}</p>
                                    <p>Mileage: {{ number_format($car->meter_usage) }} KM</p>
                                    <p class="text-lg font-bold text-black">${{ number_format($car->price) }}</p>
                                </div>
                                    @if (!Auth::user() || (Auth::user() && Auth::user()->role !== 'admin'))
                                        <a href="{{ route('cars.show', $car->id) }}"
                                            class="block mt-2 text-center bg-black text-white px-4 py-2 text-sm rounded hover:bg-gray-800">
                                            View Details
                                        </a>
                                    @endif


                            </div>
                        </div>
                    @endforeach
                </div>


                <!-- Pagination -->
                <div class="mt-8">
                    {{ $cars->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
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
    </script>
</body>

</html>
