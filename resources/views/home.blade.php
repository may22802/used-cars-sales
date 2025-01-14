<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html {
            scroll-behavior: smooth;
        }

        .bruno-ace-regular {
            font-family: "Bruno Ace", serif;
            font-weight: 400;
            font-style: normal;
            color: #1a1a1a;
            font-size: 1.8rem;
        }

        .hero-section {
            height: 100vh;
            background: linear-gradient(176deg, rgba(255, 255, 255, 1) 0%, rgba(227, 214, 214, 1) 55%, rgba(141, 142, 142, 1) 100%);
            padding-top: 80px;
        }

        .hero-section h1 {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            font-size: clamp(2.5rem, 5vw, 3.75rem);
        }

        #hero-image {
            height: 100vh;
            width: 100%;
            position: relative;
            background: linear-gradient(176deg, rgba(255, 255, 255, 1) 0%, rgba(227, 214, 214, 1) 55%, rgba(141, 142, 142, 1) 100%);
        }

        /* Remove the existing image brightness filter since we're using gradient */
        #hero-image img {
            display: none;
            /* Remove the background image */
        }

        /* Enhance text contrast against the new gradient */
        .hero-section h1 {
            color: #1a1a1a;
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.2);
        }

        .nav-gradient {
            background: linear-gradient(90deg, rgba(17, 24, 39, 1) 0%, rgba(55, 65, 81, 1) 50%, rgba(31, 41, 55, 1) 100%);
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

<body class="font-sans antialiased">
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
                    <a href="#about" class="text-gray-900 font-semibold text-lg hover:text-black">About</a>
                    <a href="#contact" class="text-gray-900 font-semibold text-lg hover:text-black">Contact</a>
                    <a href="/car-listing" class="text-gray-900 font-semibold text-lg hover:text-black">Car Listing</a>

                    <!-- Keep existing auth section but update its styling -->
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

    <!-- hero section -->
    <section class="hero-section min-h-screen flex items-center justify-center text-white relative">
        <div id="hero-image" class="relative">
            <img src="{{ asset('/Images/hero-image.jpg') }}" class="w-full h-full object-cover brightness-50" />
            <div
                class="container mx-auto px-6 text-center -mt-[150px] absolute inset-0 flex flex-col items-center justify-center">
                <h1 class="text-[45px] md:text-[60px] font-bold mb-6 text-gray-900 bruno-ace-regular leading-tight">Find
                    Premium Used Cars</h1>
                <!-- Filter Section -->
                <div class="mt-5 flex items-center justify-center">
                    <form action="{{ route('car-listing') }}" method="GET" class="w-full">
                        <div
                            class="bg-white/10 backdrop-blur-md rounded-full border border-black p-2 flex items-center gap-2 max-w-6xl w-full">
                            <div class="flex-1 flex items-center gap-2 px-4 py-2 border-r-2 border-black">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                </svg>
                                <select name="country" class="w-full bg-transparent text-gray-800 focus:outline-none">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country }}">{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex-1 flex items-center gap-2 px-4 py-2 border-r-2 border-black">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <select name="brand" class="w-full bg-transparent text-gray-800 focus:outline-none">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand }}">{{ $brand }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex-1 flex items-center gap-2 px-4 py-2 border-r-2 border-black">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <select name="year" class="w-full bg-transparent text-gray-800 focus:outline-none">
                                    <option value="">Select Year</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex-1 flex items-center gap-2 px-4 py-2 border-r-2 border-black">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <select name="fuel" class="w-full bg-transparent text-gray-800 focus:outline-none">
                                    <option value="">Fuel Type</option>
                                    @foreach ($fuelTypes as $fuelType)
                                        <option value="{{ $fuelType }}">{{ $fuelType }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit"
                                class="bg-gray-900 text-white px-8 py-3 rounded-full hover:bg-black transition-all duration-300 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Search
                            </button>
                        </div>
                    </form>
                </div>




            </div>
    </section>

    <!-- About Us / What We Offer Section -->
    <section id="about" class="py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold bruno-ace-regular mb-4">What We Offer</h2>
                <p class="text-gray-600">Experience premium service and quality vehicles at ABC Car</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="bg-gray-900 w-14 h-14 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Quality Assurance</h3>
                    <p class="text-gray-600">Every vehicle undergoes rigorous inspection and certification process</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="bg-gray-900 w-14 h-14 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 2v2m0 16v2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Competitive Pricing</h3>
                    <p class="text-gray-600">Best market rates with flexible financing options available</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                    <div class="bg-gray-900 w-14 h-14 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Expert Consultation</h3>
                    <p class="text-gray-600">Professional guidance throughout your car buying journey</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact / Start Your Journey Section -->
    <section id="contact" class="py-10 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-12 bg-gray-900 text-white">
                        <h2 class="text-3xl font-bold mb-6">Start Your Journey With Us</h2>
                        <p class="mb-8">Ready to find your perfect car? Get in touch with our team of experts.</p>

                        <div class="space-y-6">
                            <div class="flex items-center space-x-4">
                                <div class="bg-gray-800 p-3 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <span>(123) 456-7890</span>
                            </div>

                            <div class="flex items-center space-x-4">
                                <div class="bg-gray-800 p-3 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span>info@abccar.com</span>
                            </div>

                            <div class="flex items-center space-x-4">
                                <div class="bg-gray-800 p-3 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <span>123 Car Street, Auto City</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-12">
                        <form class="space-y-6">
                            <div>
                                <input type="text" placeholder="Your Name"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-gray-900 focus:outline-none">
                            </div>
                            <div>
                                <input type="email" placeholder="Your Email"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-gray-900 focus:outline-none">
                            </div>
                            <div>
                                <textarea rows="4" placeholder="Your Message"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-gray-900 focus:outline-none"></textarea>
                            </div>
                            <button type="submit"
                                class="w-full bg-gray-900 text-white py-3 rounded-lg hover:bg-black transition-colors duration-300">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white pb-8">

        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
            <p>&copy; {{ date('Y') }} Used Cars Sales. All rights reserved.</p>
        </div>

    </footer>
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
