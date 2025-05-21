<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Dashboard Penjual') }}
            </h2>
            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Food Items Section -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ __('Menu Anda') }}</h3>
                            <p class="text-gray-500 text-sm">{{ __('Kelola menu makanan Anda') }}</p>
                        </div>
                        <a href="{{ route('foods.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            {{ __('Tambah Menu Baru') }}
                        </a>
                    </div>
                    
                    @if($foods->isEmpty())
                        <div class="text-center py-12">
                            <div class="mx-auto h-24 w-24 text-gray-400">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h4 class="mt-4 text-lg font-medium text-gray-700">{{ __('Belum ada menu') }}</h4>
                            <p class="mt-1 text-gray-500">{{ __('Tambahkan menu pertama Anda') }}</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach($foods as $food)
                                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">
                                    <!-- Food Image -->
                                    @php
                                        $imagePath = $food->image ? 'storage/' . $food->image : null;
                                        $imageExists = $imagePath && file_exists(public_path($imagePath));
                                    @endphp
                                    
                                    @if($imageExists)
                                        <div class="h-48 w-full overflow-hidden bg-gray-100">
                                            <img src="{{ asset($imagePath) }}" alt="{{ $food->name }}" 
                                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                        </div>
                                    @else
                                        <div class="h-48 w-full bg-gray-100 flex items-center justify-center text-gray-400">
                                            <span class="text-4xl font-bold">{{ strtoupper(substr($food->name, 0, 2)) }}</span>
                                        </div>
                                    @endif
                                    
                                    <!-- Food Details -->
                                    <div class="p-4">
                                        <div class="flex justify-between items-start">
                                            <h4 class="font-semibold text-gray-800 text-lg">{{ $food->name }}</h4>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $food->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $food->is_available ? __('Tersedia') : __('Tidak Tersedia') }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-lg font-bold text-gray-900">Rp {{ number_format($food->price, 0, ',', '.') }}</p>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex justify-between">
                                        <form action="{{ route('foods.toggle', $food) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm font-medium {{ $food->is_available ? 'text-red-600 hover:text-red-800' : 'text-green-600 hover:text-green-800' }}">
                                                {{ $food->is_available ? __('Tandai Habis') : __('Tandai Tersedia') }}
                                            </button>
                                        </form>
                                        <a href="{{ route('foods.edit', $food) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                            {{ __('Ubah') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>