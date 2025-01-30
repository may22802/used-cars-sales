<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - {{ $car->brand }} {{ $car->model }}</title>
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

    <div class="container mx-auto px-4 pt-24 pb-8 flex items-center justify-center min-h-screen">
        @if (session('success'))
            <div id="successMessage"
                class="fixed top-20 right-6 bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-y-0 opacity-0 hidden">
                <span class="block text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div id="errorMessage"
                class="fixed top-20 right-6 bg-red-100 border border-red-400 text-red-700 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-y-0 opacity-0 hidden">
                <span class="block text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="max-w-5xl w-full">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('car-listing') }}" class="flex items-center text-gray-600 hover:text-black">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Listings
                </a>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex gap-12">
                    <!-- Left: Car Images -->
                    <div class="w-1/3">
                        <div class="h-[300px] overflow-hidden rounded-xl">
                            @if ($car->photos->count() > 0)
                                <img src="{{ Storage::url($car->photos->first()->photo_path) }}"
                                    alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </div>

                    <!-- Right: Car Details -->
                    <div class=" px-6 w-2/3">
                        <!-- Header Info -->
                        <div class="border-b pb-4 mb-6">
                            <h1 class="text-3xl font-bold">{{ $car->brand }} {{ $car->model }}</h1>
                            <p class="text-2xl font-bold text-blue-600 mt-2">${{ number_format($car->price) }}</p>
                        </div>

                        <!-- Key Details -->
                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-gray-600 text-sm">Year</span>
                                <p class="text-xl font-semibold">{{ $car->year }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-gray-600 text-sm">Fuel Type</span>
                                <p class="text-xl font-semibold">{{ ucfirst($car->fuel) }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-gray-600 text-sm">Mileage</span>
                                <p class="text-xl font-semibold">{{ number_format($car->meter_usage) }} KM</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <span class="text-gray-600 text-sm">Status</span>
                                <p
                                    class="text-xl font-semibold {{ $car->approved_bid ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $car->approved_bid ? 'Sold Out' : 'Available' }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4">
                            @auth
                                @if (!$car->approved_bid)
                                    <button onclick="openBidModal()"
                                        class="flex-1 bg-black text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 transition">
                                        Place Bid
                                    </button>
                                    <button onclick="openTestDriveModal()"
                                        class="flex-1 bg-gray-100 text-gray-800 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
                                        Book Test Drive
                                    </button>
                                @else
                                    <button disabled
                                        class="flex-1 bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                                        Place Bid
                                    </button>
                                    <button disabled
                                        class="flex-1 bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                                        Book Test Drive
                                    </button>
                                @endif
                            @else
                                @if (!$car->approved_bid)
                                    <a href="{{ route('login') }}"
                                        class="flex-1 bg-black text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 transition text-center">
                                        Login to Place Bid
                                    </a>
                                    <a href="{{ route('login') }}"
                                        class="flex-1 bg-gray-100 text-gray-800 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition text-center">
                                        Login to Book Test Drive
                                    </a>
                                @else
                                    <button disabled
                                        class="flex-1 bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                                        Car Sold
                                    </button>
                                    <button disabled
                                        class="flex-1 bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                                        Not Available
                                    </button>
                                @endif
                            @endauth
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Bid Modal -->
    <div id="bidModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white p-6 rounded-lg w-96">
                <h2 class="text-xl font-bold mb-4">Place Your Bid</h2>
                <form action="{{ route('bids.store', $car->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Bid Amount ($)</label>
                        <input type="number" name="amount" min="{{ $car->price }}"
                            class="w-full px-4 py-2 border rounded" required>
                    </div>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeBidModal()"
                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded">Cancel</button>
                        <button type="submit" class="bg-black text-white px-4 py-2 rounded">Submit Bid</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Test Drive Modal -->
    <div id="testDriveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white p-6 rounded-lg w-96">
                <h2 class="text-xl font-bold mb-4">Book Test Drive</h2>
                <form action="{{ route('test-drives.store', $car->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700">Select Date</label>
                        <input type="date" name="date" min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-2 border rounded" onchange="getAvailableTimeSlots(this.value)"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Select Time</label>
                        <select name="time" id="timeSlots" class="w-full px-4 py-2 border rounded" required>
                            <option value="">Select a date first</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeTestDriveModal()"
                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded">Cancel</button>
                        <button type="submit" class="bg-black text-white px-4 py-2 rounded">Book Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openBidModal() {
            document.getElementById('bidModal').classList.remove('hidden');
        }

        function closeBidModal() {
            document.getElementById('bidModal').classList.add('hidden');
        }

        function openTestDriveModal() {
            document.getElementById('testDriveModal').classList.remove('hidden');
        }

        function closeTestDriveModal() {
            document.getElementById('testDriveModal').classList.add('hidden');
        }

        function getAvailableTimeSlots(date) {
            fetch(`/api/available-times/${date}`)
                .then(response => response.json())
                .then(data => {
                    const timeSlots = document.getElementById('timeSlots');
                    timeSlots.innerHTML = '';
                    data.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot;
                        option.textContent = slot;
                        timeSlots.appendChild(option);
                    });
                });
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

        @if (session('success'))
            const successMessage = document.getElementById('successMessage');
            successMessage.classList.remove('hidden', 'opacity-0');
            successMessage.classList.add('opacity-100');

            setTimeout(() => {
                successMessage.classList.remove('opacity-100');
                successMessage.classList.add('opacity-0');
                setTimeout(() => {
                    successMessage.classList.add('hidden');
                }, 300);
            }, 3000);
        @endif

        @if (session('error'))
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.classList.remove('hidden', 'opacity-0');
            errorMessage.classList.add('opacity-100');

            setTimeout(() => {
                errorMessage.classList.remove('opacity-100');
                errorMessage.classList.add('opacity-0');
                setTimeout(() => {
                    errorMessage.classList.add('hidden');
                }, 300);
            }, 3000);
        @endif
    </script>
</body>

</html>
