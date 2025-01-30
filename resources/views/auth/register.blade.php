<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Register</title>
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
                    <a href="{{ url('/#about') }}"
                        class="text-gray-900 font-semibold text-lg hover:text-black">About</a>
                    <a href="{{ url('/#contact') }}"
                        class="text-gray-900 font-semibold text-lg hover:text-black">Contact</a>
                    <a href="/car-listing" class="text-gray-900 font-semibold text-lg hover:text-black">Car Listing</a>
                    <a href="{{ route('login') }}"
                        class="text-gray-900 font-semibold text-lg hover:text-black">Login</a>
                    <a href="{{ route('register') }}"
                        class="bg-gray-900 text-white px-6 py-2 rounded-md hover:bg-black font-semibold">Join us</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Registration Form with Role Selection -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <form method="POST" action="{{ route('register') }}"
            class="mt-[100px] w-full max-w-6xl p-6 bg-white rounded-lg shadow-md">
            @csrf
            <h2 style="font-size: 20px" class="bruno-ace-regular text-2xl font-bold mb-6 text-center">Create Your Account</h2>

            <div class="grid grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone"
                        :value="old('phone')" required />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Address -->
                <div>
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                        :value="old('address')" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <!-- Hidden Role Input -->
            <input type="hidden" name="role" id="role" value="">

            <div class="flex items-center justify-end mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button type="submit" onclick="setRole('user')" class="ms-4 bg-black text-white px-4 py-2 rounded-md ">
                    {{ __('Register') }}
                </button>

                {{-- <button type="submit" onclick="setRole('admin')" class="ms-4 border border-black text-black px-4 py-2 rounded-md ">
                    {{ __('Register as Admin') }}
                </button> --}}
            </div>
        </form>

    </div>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-white pb-8">

        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
            <p>&copy; {{ date('Y') }} Used Cars Sales. All rights reserved.</p>
        </div>

    </footer>

    <script>
        function setRole(role) {
            document.getElementById('role').value = role;
        }
    </script>
</body>

</html>
