<x-app-layout>
    <!-- Hero Section -->
    <section class="relative py-16 md:py-24 z-10" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">
        <div class="container mx-auto px-6">
            <div class="flex flex-col items-center md:flex-row">
                <div class="md:w-1/2 transform transition-all duration-1000 ease-out"
                     x-bind:class="shown ? 'translate-x-0 opacity-100' : '-translate-x-full opacity-0'">
                    <h1 class="text-4xl font-bold leading-tight text-gray-800 md:text-5xl lg:text-6xl">
                        Makanan Lezat <br>
                        <span class="bg-gradient-to-r from-[#213448] to-[#547792] bg-clip-text text-transparent">Diantar</span> Ke Anda
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        Pesan makanan favorit Anda dari restoran terbaik di kota dan dapatkan pengiriman cepat ke depan pintu Anda.
                    </p>
                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('login') }}" class="transform rounded-lg bg-gradient-to-r from-[#213448] to-[#547792] px-6 py-3 font-medium text-white shadow-md transition duration-300 hover:-translate-y-0.5 hover:from-[#1a2a3a] hover:to-[#4a6a85] hover:shadow-lg">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="rounded-lg border border-[#213448] px-6 py-3 font-medium text-[#213448] transition duration-300 hover:bg-gray-50">
                            Daftar
                        </a>
                    </div>
                </div>
                <div class="mt-12 md:mt-0 md:w-1/2 transform transition-all duration-1000 ease-out"
                     x-bind:class="shown ? 'translate-x-0 opacity-100' : 'translate-x-full opacity-0'">
                    <div class="relative">
                        <img class="mx-auto w-full max-w-lg rounded-2xl shadow-xl" src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Makanan Lezat">
                        <div class="absolute -bottom-6 -left-6 hidden rounded-xl bg-white p-4 shadow-lg md:block transform transition-all delay-500 duration-700"
                             x-bind:class="shown ? 'translate-y-0 opacity-100' : 'translate-y-full opacity-0'">
                            <div class="flex items-center">
                                <div class="rounded-full bg-[#e6eaee] p-3">
                                    <svg class="h-6 w-6 text-[#213448]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-gray-500">Waktu Pengiriman</p>
                                    <p class="font-semibold text-gray-800">5-45 menit</p>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -right-6 -top-6 hidden rounded-xl bg-white p-4 shadow-lg md:block transform transition-all delay-700 duration-700"
                             x-bind:class="shown ? 'translate-y-0 opacity-100' : '-translate-y-full opacity-0'">
                            <div class="flex items-center">
                                <div class="rounded-full bg-[#e6eaee] p-3">
                                    <svg class="h-6 w-6 text-[#213448]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.519 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.519-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-gray-500">Hanya untuk</p>
                                    <p class="font-semibold text-gray-800">Bayar di Tempat (COD)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating background elements -->
    <div class="fixed inset-0 -z-10 hidden overflow-hidden sm:block">
        <div class="left-1/6 animate-float absolute top-1/4">
            <svg class="h-12 w-12 text-[#213448]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="right-1/5 animate-float animation-delay-2000 absolute top-1/3">
            <svg class="h-10 w-10 text-[#547792]" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <div class="animate-float animation-delay-3000 absolute bottom-1/4 left-1/4">
            <svg class="h-14 w-14 text-[#213448] opacity-70" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
        </div>
    </div>

    <!-- Popular Meals Section -->
    <section class="relative z-10 mt-12 rounded-t-3xl bg-white/80 py-12 backdrop-blur-sm">
        <div class="container mx-auto px-6">
            <div class="mb-12 text-center">
                <h2 class="text-3xl font-bold text-gray-800">Menu Populer Kami</h2>
                <p class="mt-2 text-gray-600">Pilih dari berbagai pilihan makanan lezat yang kami sediakan</p>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @php
                    $topRatedFoods = \App\Models\Food::with(['seller', 'ratings'])
                        ->withAvg('ratings as average_rating', 'rating')
                        ->where('is_available', true)
                        ->orderByDesc('average_rating')
                        ->take(3)
                        ->get();

                    $medalColors = [
                        1 => [
                            'bg' => 'bg-yellow-500',
                            'text' => 'text-yellow-800',
                            'label' => 'Terbaik',
                            'shadow' => 'hover:shadow-yellow-200'
                        ],
                        2 => [
                            'bg' => 'bg-gray-300',
                            'text' => 'text-gray-800',
                            'label' => 'Kedua',
                            'shadow' => 'hover:shadow-gray-200'
                        ],
                        3 => [
                            'bg' => 'bg-orange-300',
                            'text' => 'text-orange-800',
                            'label' => 'Ketiga',
                            'shadow' => 'hover:shadow-orange-200'
                        ]
                    ];
                @endphp

                @foreach($topRatedFoods as $index => $food)
                    @php $rank = $index + 1; @endphp
                    <div class="food-card overflow-hidden rounded-xl bg-white shadow-md transition-all duration-300 hover:-translate-y-2 {{ $medalColors[$rank]['shadow'] }} hover:shadow-2xl relative">
                        <!-- Medal Badge -->
                        <div class="absolute left-4 top-4 z-10 flex items-center gap-1 {{ $medalColors[$rank]['bg'] }} px-2 py-1 rounded-full">
                            <svg class="w-4 h-4 {{ $medalColors[$rank]['text'] }}" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.616a1 1 0 01.894-1.79l1.599.8L9 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L5 10.274zm10 0l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L15 10.274z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-xs font-bold {{ $medalColors[$rank]['text'] }}">{{ $medalColors[$rank]['label'] }}</span>
                        </div>

                        <div class="relative h-48 overflow-hidden">
                            @if($food->image)
                                <img class="h-full w-full transform object-cover transition duration-500 hover:scale-105" 
                                     src="{{ Storage::url($food->image) }}" 
                                     alt="{{ $food->name }}">
                            @else
                                <div class="h-full w-full bg-gray-200 flex items-center justify-center">
                                    <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" 
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute right-4 top-4 rounded-full bg-[#8E1616] px-2 py-1 text-xs font-bold text-white">
                                {{ number_format($food->average_rating, 1) }} ★
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <h3 class="text-xl font-bold text-gray-800">{{ $food->name }}</h3>
                                <span class="rounded bg-[#e6eaee] px-2.5 py-0.5 text-xs font-semibold text-[#213448]">
                                    Rp {{ number_format($food->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Dari <span class="font-medium">{{ $food->seller->name }}</span></p>
                            <a href="{{ route('orders.create', ['food' => $food->id]) }}" 
                               class="mt-4 inline-block w-full bg-[#547792] text-center text-white px-4 py-2 rounded-lg hover:bg-[#47687d] transition-all">
                                Pesan Sekarang
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
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

        .food-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</x-app-layout>
