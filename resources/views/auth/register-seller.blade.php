<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.bunny.net" rel="preconnect">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-orange-50 to-amber-50 p-4 sm:p-8">
        <div class="w-full max-w-md">
            <!-- Animated food icons floating in background - Hidden on mobile -->
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

            <div class="relative z-10">
                <!-- Login Card with glass morphism effect -->
                <div class="animate__animated animate__fadeIn w-full overflow-hidden rounded-2xl border border-white/20 bg-white/80 shadow-xl backdrop-blur-sm transition-all duration-300 hover:shadow-2xl sm:max-w-md">
                    <div class="p-6 sm:p-8">
                        <!-- Header with food illustration -->
                        <div class="mb-4 text-center sm:mb-6">
                            <div class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-full bg-orange-100 sm:mb-4 sm:h-20 sm:w-20">
                                <svg
                                    class="h-10 w-10 text-orange-500 sm:h-12 sm:w-12"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <h1 class="text-xl font-bold text-gray-800 sm:text-2xl">{{ __('Welcome Back!') }}</h1>
                            <p class="mt-1 text-xs text-gray-600 sm:text-sm">{{ __('Log in to order your favorite meals') }}</p>
                        </div>

                        <x-auth-session-status class="mb-3 sm:mb-4" :status="session('status')" />

                        <form class="space-y-4 sm:space-y-5" method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email/Phone Field -->
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-700 sm:text-sm" for="login">{{ __('Email or Phone') }}</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg
                                            class="h-4 w-4 text-gray-400 sm:h-5 sm:w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        class="block w-full rounded-lg border border-gray-300 py-2 pl-9 pr-3 text-xs shadow-sm transition duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500 sm:pl-10 sm:text-sm"
                                        id="login"
                                        name="login"
                                        type="text"
                                        value="{{ old('login') }}"
                                        required
                                        autofocus
                                    >
                                </div>
                                <x-input-error class="mt-1 text-xs" :messages="$errors->get('login')" />
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-700 sm:text-sm" for="password">{{ __('Password') }}</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg
                                            class="h-4 w-4 text-gray-400 sm:h-5 sm:w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        class="block w-full rounded-lg border border-gray-300 py-2 pl-9 pr-3 text-xs shadow-sm transition duration-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-500 sm:pl-10 sm:text-sm"
                                        id="password"
                                        name="password"
                                        type="password"
                                        required
                                    >
                                </div>
                                <x-input-error class="mt-1 text-xs" :messages="$errors->get('password')" />
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input class="h-4 w-4 rounded border-gray-300 text-orange-600 focus:ring-orange-500" id="remember_me" name="remember" type="checkbox">
                                    <label class="ml-2 block text-xs text-gray-700 sm:text-sm" for="remember_me">{{ __('Remember me') }}</label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a class="text-xs font-medium text-orange-600 transition duration-200 hover:text-orange-500 sm:text-sm" href="{{ route('password.request') }}">
                                        {{ __('Forgot password?') }}
                                    </a>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <button class="flex w-full transform items-center justify-center rounded-lg border border-transparent bg-gradient-to-r from-orange-500 to-amber-500 px-4 py-2 text-xs font-medium text-white shadow-sm transition-all duration-300 hover:scale-[1.02] hover:from-orange-600 hover:to-amber-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 sm:text-sm" type="submit">
                                <svg
                                    class="mr-2 h-4 w-4 sm:h-5 sm:w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                {{ __('Log in') }}
                            </button>
                        </form>

                        <!-- Register Link -->
                        <div class="mt-4 text-center sm:mt-6">
                            <p class="text-xs text-gray-600 sm:text-sm">
                                {{ __("Don't have an account?") }}
                                <a class="font-medium text-orange-600 transition duration-200 hover:text-orange-500" href="{{ route('register') }}">
                                    {{ __('Sign up') }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-3000 {
            animation-delay: 3s;
        }

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
    </style>
</body>

</html>
