<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Seller Login</title>

    <link href="https://fonts.bunny.net" rel="preconnect">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-[#e6eaee] to-[#d1dbe3] p-4 sm:p-8">
        <div class="w-full max-w-md">
            <!-- Animated icons floating in background - Hidden on mobile -->
            <div class="absolute inset-0 z-0 hidden items-center justify-between p-8 sm:flex">
                <div class="animate-float h-8 w-8 text-[#547792]" style="animation-delay: 0s">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
                <div class="animate-float h-6 w-6 text-[#213448]" style="animation-delay: 1s">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
                <div class="animate-float h-10 w-10 text-[#8E1616]" style="animation-delay: 2s">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
            </div>

            <div class="relative z-10">
                <!-- Login Card with glass morphism effect -->
                <div class="animate__animated animate__fadeIn w-full overflow-hidden rounded-2xl border border-white/20 bg-white/80 shadow-xl backdrop-blur-sm transition-all duration-300 hover:shadow-2xl sm:max-w-md">
                    <div class="p-6 sm:p-8">
                        <!-- Header with illustration -->
                        <div class="mb-4 text-center sm:mb-6">
                            <div class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-full bg-[#e6eaee] sm:mb-4 sm:h-20 sm:w-20">
                                <svg class="h-8 w-8 text-[#213448] sm:h-10 sm:w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-800 sm:text-3xl">Seller Login</h1>
                            <p class="mt-2 text-sm text-gray-600">Access your seller dashboard</p>
                        </div>

                        @if (session('status'))
                            <div class="mb-4 text-sm font-medium text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('seller.login.submit') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-4">
                                <label class="mb-1 block text-xs font-medium text-gray-700 sm:text-sm" for="email">Email</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </div>
                                    <input id="email" class="block w-full rounded-lg border-gray-300 pl-10 text-sm focus:border-[#213448] focus:ring-[#213448]" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="your@email.com">
                                </div>
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between">
                                    <label class="mb-1 block text-xs font-medium text-gray-700 sm:text-sm" for="password">Password</label>
                                    @if (Route::has('password.request'))
                                        <a class="text-xs text-[#213448] hover:text-[#1a2a3a] hover:underline" href="{{ route('password.request') }}">
                                            Forgot password?
                                        </a>
                                    @endif
                                </div>
                                <div class="relative mt-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input id="password" class="block w-full rounded-lg border-gray-300 pl-10 text-sm focus:border-[#213448] focus:ring-[#213448]" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                                </div>
                                @error('password')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-6 block">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#213448] shadow-sm focus:ring-[#213448]" name="remember">
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button type="submit" class="flex w-full transform items-center justify-center rounded-lg border border-transparent bg-gradient-to-r from-[#213448] to-[#547792] px-4 py-2 text-sm font-medium text-white shadow-sm transition-all duration-300 hover:scale-[1.02] hover:from-[#1a2a3a] hover:to-[#4a6a85] focus:outline-none focus:ring-2 focus:ring-[#213448] focus:ring-offset-2">
                                    <svg class="mr-2 h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log in') }}
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="mt-6 text-center">
                                <p class="text-xs text-gray-600 sm:text-sm">
                                    Don't have a seller account?
                                    <a href="{{ route('seller.register') }}" class="font-medium text-[#213448] hover:text-[#1a2a3a] hover:underline">
                                        Register here
                                    </a>
                                </p>
                            </div>

                            <!-- Back to Home -->
                            <div class="mt-4 text-center">
                                <a href="{{ url('/') }}" class="text-xs text-gray-500 hover:text-[#213448] hover:underline">
                                    ← Back to Home
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .animate-delay-2000 {
            animation-delay: 2s;
        }

        .animate-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>
</html>
