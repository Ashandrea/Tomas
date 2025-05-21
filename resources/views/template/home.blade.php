<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Siswa | Order Delicious Meals Online</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-3000 {
            animation-delay: 3s;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .food-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>

</head>

<body class="min-h-screen bg-gradient-to-br from-orange-50 to-amber-50">
    <!-- Floating background elements -->
    <div class="fixed inset-0 z-0 hidden overflow-hidden sm:block">
        <div class="left-1/6 animate-float absolute top-1/4">
            <svg class="h-12 w-12 text-amber-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="right-1/5 animate-float animation-delay-2000 absolute top-1/3">
            <svg class="h-10 w-10 text-orange-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="animate-float animation-delay-3000 absolute bottom-1/4 left-1/4">
            <svg class="h-14 w-14 text-amber-400 opacity-70" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-10 border-b border-white/20 bg-white/80 backdrop-blur-sm">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo and Name -->
                <div class="flex items-center space-x-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-orange-500 to-amber-500 text-white">
                        <svg
                            class="h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800">Toko Siswa</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden items-center space-x-8 md:flex">
                    <a class="font-medium text-gray-700 transition duration-300 hover:text-orange-500" href="#">Home</a>
                    <a class="font-medium text-gray-700 transition duration-300 hover:text-orange-500" href="#">Order</a>
                    <a class="font-medium text-gray-700 transition duration-300 hover:text-orange-500" href="#">About</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- User dropdown for logged-in users -->
                        <div class="relative" x-data="{ open: false }">
                            <button class="flex items-center space-x-2 transition-all duration-200 hover:opacity-80 focus:outline-none" x-on:click="open = !open" x-on:keydown.escape="open = false">
                                <div class="relative h-9 w-9 overflow-hidden rounded-full bg-gradient-to-br from-orange-100 to-amber-100 shadow">
                                    @if (auth()->user()->profile_photo_path)
                                        <img class="h-full w-full object-cover" src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile Photo" loading="lazy">
                                    @else
                                        <span class="flex h-full w-full items-center justify-center bg-gradient-to-r from-orange-500 to-amber-500 font-medium text-white">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </span>
                                    @endif
                                </div>
                                <span class="hidden text-sm font-medium text-gray-700 sm:block">{{ auth()->user()->name }}</span>
                                <svg
                                    class="h-4 w-4 text-gray-400 transition-transform duration-200"
                                    :class="{ 'rotate-180': open }"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                                class="absolute right-0 z-50 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-xl bg-white p-1 shadow-lg ring-1 ring-black/5 backdrop-blur-sm focus:outline-none"
                                style="display: none;"
                                x-show="open"
                                x-on:click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                x-cloak
                            >
                                <div class="px-4 py-3">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="truncate text-xs text-gray-500">{{ auth()->user()->role->label() }}</p>
                                </div>

                                <div class="py-1">
                                    <a class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100/80 hover:text-orange-600" href="#">
                                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profile
                                    </a>
                                    <a class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100/80 hover:text-orange-600" href="#">
                                        <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Settings
                                    </a>
                                </div>

                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100/80 hover:text-orange-600" type="submit">
                                            <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Login/Register buttons for guests -->
                        <a class="hidden font-medium text-gray-700 transition duration-300 hover:text-orange-500 sm:block" href="{{ route('login') }}">Login</a>
                        <a class="transform rounded-lg bg-gradient-to-r from-orange-500 to-amber-500 px-4 py-2 font-medium text-white shadow-md transition duration-300 hover:-translate-y-0.5 hover:from-orange-600 hover:to-amber-600 hover:shadow-lg" href="{{ route('register') }}">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative py-16 md:py-24">
        <div class="container mx-auto px-6">
            <div class="flex flex-col items-center md:flex-row">
                <div class="animate__animated animate__fadeInLeft md:w-1/2">
                    <h1 class="text-4xl font-bold leading-tight text-gray-800 md:text-5xl lg:text-6xl">
                        Delicious Food <br>
                        <span class="bg-gradient-to-r from-orange-500 to-amber-500 bg-clip-text text-transparent">Delivered</span> To You
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        Order your favorite meals from the best restaurants in town and get them delivered fast to your doorstep.
                    </p>
                    <div class="mt-8 flex space-x-4">
                        <button class="transform rounded-lg bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-3 font-medium text-white shadow-md transition duration-300 hover:-translate-y-0.5 hover:from-orange-600 hover:to-amber-600 hover:shadow-lg">
                            Order Now
                        </button>
                        <button class="rounded-lg border border-orange-500 px-6 py-3 font-medium text-orange-500 transition duration-300 hover:bg-orange-50">
                            Learn More
                        </button>
                    </div>
                </div>
                <div class="animate__animated animate__fadeInRight mt-12 md:mt-0 md:w-1/2">
                    <div class="relative">
                        <img class="mx-auto w-full max-w-lg rounded-2xl shadow-xl" src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Delicious Food">
                        <div class="absolute -bottom-6 -left-6 hidden rounded-xl bg-white p-4 shadow-lg md:block">
                            <div class="flex items-center">
                                <div class="rounded-full bg-orange-100 p-3">
                                    <svg
                                        class="h-6 w-6 text-orange-500"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-gray-500">Delivery Time</p>
                                    <p class="font-semibold text-gray-800">30-45 min</p>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -right-6 -top-6 hidden rounded-xl bg-white p-4 shadow-lg md:block">
                            <div class="flex items-center">
                                <div class="rounded-full bg-amber-100 p-3">
                                    <svg
                                        class="h-6 w-6 text-amber-500"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-gray-500">Customer Rating</p>
                                    <p class="font-semibold text-gray-800">4.8 (2.4k)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Meals Section -->
    <section class="relative z-10 mt-12 rounded-t-3xl bg-white/80 py-12 backdrop-blur-sm">
        <div class="container mx-auto px-6">
            <div class="mb-12 text-center">
                <h2 class="text-3xl font-bold text-gray-800">Our Popular Meals</h2>
                <p class="mt-2 text-gray-600">Choose from our carefully curated selection of delicious meals</p>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Food Card 1 -->
                <div class="food-card overflow-hidden rounded-xl bg-white shadow-md transition duration-300 hover:shadow-lg">
                    <div class="relative h-48 overflow-hidden">
                        <img class="h-full w-full transform object-cover transition duration-500 hover:scale-105" src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Salad">
                        <div class="absolute right-4 top-4 rounded-full bg-orange-500 px-2 py-1 text-xs font-bold text-white">
                            Popular
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <h3 class="text-xl font-bold text-gray-800">Fresh Salad Bowl</h3>
                            <span class="rounded bg-orange-100 px-2.5 py-0.5 text-xs font-semibold text-orange-800">$12.99</span>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">Fresh vegetables with special dressing</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="ml-1 text-gray-700">4.8</span>
                            </div>
                            <button class="flex items-center text-sm font-medium text-orange-500 hover:text-orange-600">
                                <svg
                                    class="h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add to cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Food Card 2 -->
                <div class="food-card overflow-hidden rounded-xl bg-white shadow-md transition duration-300 hover:shadow-lg">
                    <div class="relative h-48 overflow-hidden">
                        <img class="h-full w-full transform object-cover transition duration-500 hover:scale-105" src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Burger">
                        <div class="absolute right-4 top-4 rounded-full bg-red-500 px-2 py-1 text-xs font-bold text-white">
                            Hot
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <h3 class="text-xl font-bold text-gray-800">Classic Burger</h3>
                            <span class="rounded bg-orange-100 px-2.5 py-0.5 text-xs font-semibold text-orange-800">$9.99</span>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">Juicy beef patty with fresh veggies</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="ml-1 text-gray-700">4.5</span>
                            </div>
                            <button class="flex items-center text-sm font-medium text-orange-500 hover:text-orange-600">
                                <svg
                                    class="h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add to cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Food Card 3 -->
                <div class="food-card overflow-hidden rounded-xl bg-white shadow-md transition duration-300 hover:shadow-lg">
                    <div class="relative h-48 overflow-hidden">
                        <img class="h-full w-full transform object-cover transition duration-500 hover:scale-105" src="https://images.unsplash.com/photo-1473093295043-cdd812d0e601?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Pizza">
                        <div class="absolute right-4 top-4 rounded-full bg-green-500 px-2 py-1 text-xs font-bold text-white">
                            New
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <h3 class="text-xl font-bold text-gray-800">Margherita Pizza</h3>
                            <span class="rounded bg-orange-100 px-2.5 py-0.5 text-xs font-semibold text-orange-800">$14.99</span>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">Classic Italian pizza with fresh basil</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="ml-1 text-gray-700">4.9</span>
                            </div>
                            <button class="flex items-center text-sm font-medium text-orange-500 hover:text-orange-600">
                                <svg
                                    class="h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add to cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <button class="rounded-lg border border-orange-500 px-6 py-3 font-medium text-orange-500 transition duration-300 hover:bg-orange-50">
                    View All Menu
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-8">
        <div class="container mx-auto px-6">
            <div class="flex flex-col items-center justify-between md:flex-row">
                <div class="flex items-center space-x-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-orange-500 to-amber-500 text-white">
                        <svg
                            class="h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800">Toko Siswa</span>
                </div>
                <div class="mt-4 flex space-x-6 md:mt-0">
                    <a class="text-gray-600 transition duration-300 hover:text-orange-500" href="#">Home</a>
                    <a class="text-gray-600 transition duration-300 hover:text-orange-500" href="#">Order</a>
                    <a class="text-gray-600 transition duration-300 hover:text-orange-500" href="#">About</a>
                    <a class="text-gray-600 transition duration-300 hover:text-orange-500" href="#">Contact</a>
                </div>
                <div class="mt-4 md:mt-0">
                    <p class="text-sm text-gray-500">© {{ now()->format('Y') }} Toko Siswa. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
