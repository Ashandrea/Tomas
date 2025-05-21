<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Daftar</title>

    <link href="https://fonts.bunny.net" rel="preconnect">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-[#547792] to-[#547792] p-4 sm:p-8">
        <div class="w-full max-w-md">
            <!-- Animated food icons floating in background - Hidden on mobile -->
            <div class="absolute inset-0 z-0 hidden items-center justify-between p-8 sm:flex">
                <div class="animate-float h-8 w-8 text-white" style="animation-delay: 0s">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
                <div class="animate-float h-6 w-6 text-white" style="animation-delay: 1s">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
                <div class="animate-float h-10 w-10 text-white" style="animation-delay: 2s">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
            </div>

            <div class="relative z-10">
                <!-- Register Card with glass morphism effect -->
                <div class="animate__animated animate__fadeIn w-full overflow-hidden rounded-2xl border border-white/20 bg-white/80 shadow-xl backdrop-blur-sm transition-all duration-300 hover:shadow-2xl sm:max-w-md">
                    <div class="p-6 sm:p-8">
                        <!-- Header with food illustration -->
                        <div class="mb-4 text-center sm:mb-6">
                            <div class="mx-auto mb-3 flex h-16 w-16 items-center justify-center rounded-full bg-[#547792] sm:mb-4 sm:h-20 sm:w-20">
                                <svg class="h-8 w-8 text-white sm:h-10 sm:w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-800 sm:text-3xl">Buat Akun</h1>
                            <p class="mt-2 text-sm text-gray-600">Bergabunglah untuk memulai perjalanan kuliner Anda</p>
                        </div>

                        <form class="space-y-5 sm:space-y-6" method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name Field -->
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-700 sm:text-sm" for="name">{{ __('Nama Lengkap') }}</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input id="name" class="block w-full rounded-lg border-gray-300 pl-10 py-2.5 text-sm focus:border-orange-500 focus:ring-orange-500" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama lengkap Anda">
                                </div>
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-700 sm:text-sm" for="email">{{ __('Email') }}</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </div>
                                    <input id="email" class="block w-full rounded-lg border-gray-300 pl-10 py-2.5 text-sm focus:border-orange-500 focus:ring-orange-500" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email@contoh.com">
                                </div>
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number Field -->
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-700 sm:text-sm" for="phone">{{ __('Nomor Telepon') }}</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input id="phone" class="block w-full rounded-lg border-gray-300 pl-10 py-2.5 text-sm focus:border-orange-500 focus:ring-orange-500" type="tel" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="0812-3456-7890">
                                </div>
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role Selection -->
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-700 sm:text-sm" for="role">{{ __('Peran') }}</label>
                                <div class="relative">
                                    <select id="role" name="role" class="block w-full rounded-lg border-gray-300 pl-10 pr-3 py-2.5 text-sm focus:border-orange-500 focus:ring-orange-500" required>
                                        <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>{{ __('Pembeli') }}</option>
                                        <option value="seller" {{ old('role') === 'seller' ? 'selected' : '' }}>{{ __('Penjual') }}</option>
                                        <option value="courier" {{ old('role') === 'courier' ? 'selected' : '' }}>{{ __('Kurir') }}</option>
                                        <option value="mahasiswa" {{ old('role') === 'mahasiswa' ? 'selected' : '' }}>{{ __('Mahasiswa') }}</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                @error('role')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-700 sm:text-sm" for="password">{{ __('Kata Sandi') }}</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input id="password" class="block w-full rounded-lg border-gray-300 pl-10 py-2.5 text-sm focus:border-orange-500 focus:ring-orange-500" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
                                </div>
                                @error('password')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-700 sm:text-sm" for="password_confirmation">{{ __('Konfirmasi Kata Sandi') }}</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input id="password_confirmation" class="block w-full rounded-lg border-gray-300 pl-10 py-2.5 text-sm focus:border-orange-500 focus:ring-orange-500" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                                </div>
                            </div>

                            <!-- Register Button -->
                            <div class="pt-3">
                                <button type="submit" class="flex w-full transform items-center justify-center rounded-lg border border-transparent bg-gradient-to-r from-[#213448] to-[#547792] px-4 py-2 text-sm font-medium text-white shadow-sm transition-all duration-300 hover:scale-[1.02] hover:from-[#213448] hover:to-[#547792] focus:outline-none focus:ring-2 focus:ring-[#547792] focus:ring-offset-2">
                                    <svg class="mr-2 h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Daftar') }}
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="mt-4 text-center">
                                <p class="text-xs text-gray-600 sm:text-sm">
                                    {{ __('Sudah punya akun?') }}
                                    <a href="{{ route('login') }}" class="font-medium text-[#213448] hover:text-[#547792]">
                                        {{ __('Masuk di sini') }}
                                    </a>
                                </p>
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
