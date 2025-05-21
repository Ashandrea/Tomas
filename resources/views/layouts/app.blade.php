<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
        <meta name="user-id" content="{{ auth()->id() }}">
    @endauth

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        // Function to update localized content without page reload
        window.updateLocalizedContent = function(locale) {
            // Update HTML lang attribute
            document.documentElement.setAttribute('lang', locale);
            
            // Update any elements with data-translate attribute
            document.querySelectorAll('[data-translate]').forEach(element => {
                const key = element.getAttribute('data-translate');
                if (window.translations && window.translations[locale] && window.translations[locale][key]) {
                    element.textContent = window.translations[locale][key];
                }
            });
        };
        
        // Store translations in window object for client-side access
        window.translations = {
            'en': {
                // Add common translations here if needed
            },
            'id': {
                // Add common translations here if needed
            }
        };
    </script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @if (!request()->is('/'))
            @include('layouts.navigation')
        @endif

        <!-- Page Heading -->
        <!-- @if (isset($header))
            <header class="bg-white shadow {{ request()->is('/') ? '' : 'mt-16' }}">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center">
                        <div class="flex-1">
                            {{ $header }}
                        </div>
                    </div>
                </div>
            </header>
        @endif -->

        <!-- Notifications -->
        <x-notification />

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <footer class="bg-[#213448] border-t border-gray-200 py-4 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <p>&copy; {{ date('Y') }} Toko Mahasiswa. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>