{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - User Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .tab-btn {
            @apply font-medium text-gray-600 hover:text-gray-900 focus:outline-none;
        }

        .tab-btn.active {
            @apply text-red-600 border-red-600;
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

<body class="font-sans antialiased">
    <!-- Header Section -->
    <header class="bg-white shadow fixed w-full z-50">
        <nav class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('images/logo.webp') }}" class="w-20 h-20" alt="Logo" />
                        <span class="ml-3 text-xl font-bold bruno-ace-regular">Used Cars Salses</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="/about" class="text-gray-600 hover:text-gray-900">About Us</a>
                    <a href="/contact-us" class="text-gray-600 hover:text-gray-900">Contact us</a>
                    <a href="/car-listing" class="text-gray-600 hover:text-gray-900">Car Listing</a>
                    @auth
                        <div class="relative">
                            <button id="userMenuButton" class="flex items-center space-x-2">
                                <div
                                    class="border-2 border-black rounded-full w-[45px] h-[45px] flex items-center justify-center">
                                    <span class="text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <span class="text-gray-600">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                @else
                                    <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    </header>


    <!-- After the header, replace the current dashboard content with: -->
    <div class="container mx-auto px-6 pt-24 pb-12">
        <!-- Tabs -->
        <div class="mb-8 border-b mt-[30px]">
            <div class="flex space-x-8">
                <button onclick="switchTab(this, 'profile')"
                    class="tab-btn active border-black border-b-2 px-4 py-2">Profile</button>
                <button onclick="switchTab(this, 'cars')" class="tab-btn border-b-2 px-4 py-2">My Cars</button>
            </div>
        </div>

        <!-- Profile Tab Content -->
        <div id="profile" class="tab-content">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-6">Profile Information</h2>
                <form action="{{ route('user.profile.update') }}" method="POST" class="grid grid-cols-2 gap-6">
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
                        <button type="submit" class="bg-black text-white px-6 py-2 rounded hover:bg-red-700">Update
                            Profile</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Cars Tab Content -->
        <div id="cars" class="tab-content hidden mb-[150px]">
            <div class="flex justify-end mb-6">
                <button onclick="openCarModal()"
                    class="bg-black border border-black text-white px-6 py-2 rounded flex items-center hover:bg-white hover:text-black">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Car
                </button>
            </div>

            <!-- Car Listings -->
            <div class="space-y-6">
                @foreach ($cars as $car)
                    <div class="bg-white p-6 rounded-lg shadow-md flex">
                        <div class="w-1/3">
                            @if ($car->photos->count() > 0)
                                <img src="{{ Storage::url($car->photos->first()->photo_path) }}"
                                    alt="{{ $car->brand }} {{ $car->model }}"
                                    class="w-50 h-[200px] object-cover rounded">
                            @endif
                        </div>
                        <div class="w-2/3 pl-6 grid grid-cols-2 gap-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span class="text-gray-700">{{ $car->brand }} {{ $car->model }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                                <span class="text-gray-700">{{ $car->country }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span class="text-gray-700">{{ $car->fuel }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-gray-700">{{ $car->year }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <span class="text-gray-700">${{ number_format($car->price) }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span class="text-gray-700">{{ number_format($car->meter_usage) }} KM</span>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination Links -->
                <div class="mt-6">
                    {{ $cars->links() }}
                </div>
            </div>
        </div>

        <!-- Car Modal -->
        <div id="carModal"
            class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center mt-[100px]">>
            <div class="bg-white p-8 rounded-lg w-full max-w-2xl">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Add New Car</h2>
                    <button onclick="closeCarModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('user.cars.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 mb-2">Brand</label>
                            <input type="text" name="brand" class="w-full px-4 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Model</label>
                            <input type="text" name="model" class="w-full px-4 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Country Make</label>
                            <input type="text" name="country" class="w-full px-4 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Fuel Type</label>
                            <select name="fuel" class="w-full px-4 py-2 border rounded">
                                <option value="petrol">Petrol</option>
                                <option value="diesel">Diesel</option>
                                <option value="electric">Electric</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Registration Year</label>
                            <input type="number" name="year" class="w-full px-4 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Price (USD)</label>
                            <input type="number" name="price" class="w-full px-4 py-2 border rounded">
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Meter Usage (KM)</label>
                            <input type="number" name="meter_usage" class="w-full px-4 py-2 border rounded">
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-2">Car Photos</label>
                            <input type="file" name="photos[]" multiple class="w-full px-4 py-2 border rounded"
                                accept="image/*">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="button" onclick="closeCarModal()"
                            class="mr-4 px-4 py-2 text-gray-500 hover:text-gray-700">Cancel</button>
                        <button type="submit" class="bg-black text-white px-6 py-2 rounded">Add
                            Car</button>
                    </div>
                </form>
            </div>
        </div>

    </div>






    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">About Us</h3>
                    <p class="text-gray-300">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Omnis quibusdam eum est, voluptatum libero numquam ipsam quae ipsa</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Home</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">About</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Car Listing</a>
                        </li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Contact Info</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li>Phone: (555) 123-4567</li>
                        <li>Email: info@usedcarssales.org</li>
                        <li>Address: 123 Used Cars Street</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.897 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.897-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; {{ date('Y') }} Used Cars Sales. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function switchTab(element, tabName) {
            const tabs = document.querySelectorAll('.tab-content');
            const buttons = document.querySelectorAll('.tab-btn');

            tabs.forEach(tab => tab.classList.add('hidden'));
            buttons.forEach(btn => {
                btn.classList.remove('active', 'border-black');
            });

            document.getElementById(tabName).classList.remove('hidden');
            element.classList.add('active', 'border-black');
        }

        function openCarModal() {
            document.getElementById('carModal').classList.remove('hidden');
            document.getElementById('carModal').classList.add('flex');
        }

        function closeCarModal() {
            document.getElementById('carModal').classList.add('hidden');
            document.getElementById('carModal').classList.remove('flex');
        }
        // Add to your existing script section
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

</html> --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - User Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&display=swap" rel="stylesheet">
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

<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-lg flex flex-col h-full">
        <!-- Logo -->
        <div class="p-4 border-b">
            <a href="/" class="flex items-center">
                <span class="text-xl font-bold bruno-ace-regular">ABC Car</span>
            </a>
        </div>

        <!-- Navigation Items -->
        <div class="py-4">
            <nav class="space-y-1">
                <a href="#" onclick="switchTab(this, 'profile')"
                    class="tab-btn flex items-center px-6 py-3 hover:bg-gray-100 border-l-4 {{ request()->get('tab') === 'profile' ? 'border-black bg-gray-50' : 'border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="{{ request()->get('tab') === 'profile' ? 'font-semibold' : '' }}">Profile</span>
                </a>

                <a href="#" onclick="switchTab(this, 'cars')"
                    class="tab-btn flex items-center px-6 py-3 hover:bg-gray-100 border-l-4 {{ request()->get('tab') === 'cars' ? 'border-black bg-gray-50' : 'border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16v-4m0 0v4m0-4h8m-8 0H6a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2m-8 0V8a2 2 0 012-2h4a2 2 0 012 2v4M6 20h12a2 2 0 002-2v-4a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2z" />
                    </svg>
                    <span class="{{ request()->get('tab') === 'cars' ? 'font-semibold' : '' }}">My Cars</span>
                </a>
                <a href="#" onclick="switchTab(this, 'sold-cars')"
                    class="tab-btn flex items-center px-6 py-3 hover:bg-gray-100 border-l-4 {{ request()->get('tab') === 'sold-cars' ? 'border-black bg-gray-50' : 'border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    <span class="{{ request()->get('tab') === 'sold-cars' ? 'font-semibold' : '' }}">Sold
                        cars</span>
                </a>

                <a href="#" onclick="switchTab(this, 'my-bids')"
                    class="tab-btn flex items-center px-6 py-3 hover:bg-gray-100 border-l-4 {{ request()->get('tab') === 'my-bids' ? 'border-black bg-gray-50' : 'border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="{{ request()->get('tab') === 'my-bids' ? 'font-semibold' : '' }}">My Bids</span>
                </a>

                <a href="#" onclick="switchTab(this, 'received-bids')"
                    class="tab-btn flex items-center px-6 py-3 hover:bg-gray-100 border-l-4 {{ request()->get('tab') === 'received-bids' ? 'border-black bg-gray-50' : 'border-transparent' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <span class="{{ request()->get('tab') === 'received-bids' ? 'font-semibold' : '' }}">Received
                        bids</span>
                </a>

                <a href="#" onclick="switchTab(this, 'notifications')"
    class="tab-btn flex items-center px-6 py-3 hover:bg-gray-100 border-l-4 {{ request()->get('tab') === 'notifications' ? 'border-black bg-gray-50' : 'border-transparent' }}">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
    </svg>
    <span class="{{ request()->get('tab') === 'notifications' ? 'font-semibold' : '' }}">
        Notifications
    </span>
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
            <!-- Profile Tab -->
            <div id="profile" class="tab-content">
                <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-gray-500">
                    <h2 class="text-2xl font-bold mb-6">Profile Information</h2>
                    <form action="{{ route('user.profile.update') }}" method="POST" class="grid grid-cols-2 gap-6">
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
                                class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Cars Tab -->
            <div id="cars" class="tab-content hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-gray-500">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">My Cars</h2>
                        <button onclick="openCarModal()"
                            class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add New Car
                        </button>
                    </div>
                    <!-- Rest of your cars listing code -->
                    <div class="grid grid-cols-4 ">
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
                                    <div class="mt-3 grid grid-cols-2 border-t border-gray-200 pt-2">
                                        <button onclick="openEditModal({{ $car->id }})"
                                            class="border-r border-gray-200 py-1.5 text-sm font-medium hover:bg-gray-50">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this car post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-full py-1.5 text-sm font-medium text-red-600 hover:bg-gray-50">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sold Cars Tab Content -->
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
                            <h3 class="text-lg font-bold truncate">{{ $car->brand }} {{ $car->model }}</h3>
                            <p class="text-gray-600 text-xs">Sold to: {{ $car->approved_bid->user->name }}</p>
                        </div>

                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sold Price:</span>
                                <span class="font-medium">${{ number_format($car->approved_bid->amount) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sold Date:</span>
                                <span class="font-medium">{{ $car->approved_bid->updated_at->format('M d, Y') }}</span>
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

<!-- Add this to your tab contents -->
<div id="notifications" class="tab-content hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-gray-500">
        <h2 class="text-2xl font-bold mb-6">Notifications</h2>
        <div class="space-y-4">
            @forelse($notifications as $notification)
                <div class="p-4 rounded-lg border {{ is_null($notification->read_at) ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }}">
                    <div class="flex justify-between items-start">
                        <p class="text-gray-800">{{ $notification->message }}</p>
                        <span class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    No notifications yet
                </div>
            @endforelse
        </div>
    </div>
</div>


            <!-- Car Modal -->
            <div id="carModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">>
                <div class="bg-white p-8 rounded-lg w-full max-w-2xl">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Add New Car</h2>
                        <button onclick="closeCarModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('user.cars.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 mb-2">Brand</label>
                                <input type="text" name="brand" class="w-full px-4 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Model</label>
                                <input type="text" name="model" class="w-full px-4 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Country Make</label>
                                <input type="text" name="country" class="w-full px-4 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Fuel Type</label>
                                <select name="fuel" class="w-full px-4 py-2 border rounded">
                                    <option value="petrol">Petrol</option>
                                    <option value="diesel">Diesel</option>
                                    <option value="electric">Electric</option>
                                    <option value="hybrid">Hybrid</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Registration Year</label>
                                <input type="number" name="year" class="w-full px-4 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Price (USD)</label>
                                <input type="number" name="price" class="w-full px-4 py-2 border rounded">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Meter Usage (KM)</label>
                                <input type="number" name="meter_usage" class="w-full px-4 py-2 border rounded">
                            </div>

                            <div>
                                <label class="block text-gray-700 mb-2">Car Photos</label>
                                <input type="file" name="photos[]" multiple
                                    class="w-full px-4 py-2 border rounded" accept="image/*">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="closeCarModal()"
                                class="mr-4 px-4 py-2 text-gray-500 hover:text-gray-700">Cancel</button>
                            <button type="submit" class="bg-black text-white px-6 py-2 rounded">Add
                                Car</button>
                        </div>
                    </form>
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

            <!-- My Bids Tab -->
            <div id="my-bids" class="tab-content hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-gray-500">
                    <h2 class="text-2xl font-bold mb-6">My Bids on Other Cars</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Car</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Bid Amount</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($myBids as $bid)
                                    <tr>
                                        <td class="px-6 py-4">{{ $bid->car->brand }} {{ $bid->car->model }}</td>
                                        <td class="px-6 py-4">${{ number_format($bid->amount) }}</td>
                                        <td class="px-6 py-4">{{ $bid->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 rounded-full text-xs
                                @if ($bid->status === 'approved') bg-green-100 text-green-800
                                @elseif($bid->status === 'denied') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($bid->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Received Bids Tab -->
            <div id="received-bids" class="tab-content hidden">
                <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-gray-500">
                    <h2 class="text-2xl font-bold mb-6">Bids Received on My Cars</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Car</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Bidder</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Bid Amount</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($receivedBids as $bid)
                                    <tr>
                                        <td class="px-6 py-4">{{ $bid->car->brand }} {{ $bid->car->model }}</td>
                                        <td class="px-6 py-4">{{ $bid->user->name }}</td>
                                        <td class="px-6 py-4">${{ number_format($bid->amount) }}</td>
                                        <td class="px-6 py-4">{{ $bid->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 rounded-full text-xs
                                @if ($bid->status === 'approved') bg-green-100 text-green-800
                                @elseif($bid->status === 'denied') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($bid->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($bid->status === 'pending')
                                                <form action="{{ route('user.bids.update', $bid->id) }}"
                                                    method="POST" class="flex gap-2">
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
    </div>
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
        const activeTab = urlParams.get('tab') || 'profile';
        const tabButton = document.querySelector(`[onclick*="switchTab(this, '${activeTab}')"]`);
        if (tabButton) {
            switchTab(tabButton, activeTab);
        }
    });

    function openCarModal() {
        document.getElementById('carModal').classList.remove('hidden');
        document.getElementById('carModal').classList.add('flex');
    }

    function closeCarModal() {
        document.getElementById('carModal').classList.add('hidden');
        document.getElementById('carModal').classList.remove('flex');
    }
    // Add to your existing script section
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

    function openEditModal(carId) {
        const cars = @json($cars);
        const selectedCar = cars.find(c => c.id === carId);

        document.getElementById('editCarForm').action = `/user/cars/${carId}`;
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
</script>

</html>
