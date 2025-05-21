<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Makanan Tersedia') }}
            </h2>
            <a href="{{ route('foods.create') }}" class="inline-flex items-center px-4 py-2 bg-[#547792] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#47687d] focus:bg-[#47687d] active:bg-[#3a5a70] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Tambah Makanan Baru') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <!-- Search Bar -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">{{ __('Semua Menu Makanan') }}</h3>
                        <div class="relative">
                            <input type="text" 
                                   id="search"
                                   name="search"
                                   placeholder="{{ __('Cari makanan...') }}"
                                   class="w-64 rounded-lg border-gray-300 focus:border-[#547792] focus:ring focus:ring-[#547792] focus:ring-opacity-50">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    @if($foods->isEmpty())
                        <div class="text-center py-16">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">{{ __('Belum ada menu makanan') }}</h3>
                            <p class="mt-1 text-gray-500">{{ __('Mulai dengan menambahkan menu makanan baru.') }}</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($foods as $food)
                                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                                    <div class="relative">
                                        <img src="{{ $food->image ? Storage::url($food->image) : 'https://via.placeholder.com/400x300?text=No+Image' }}" 
                                             alt="{{ $food->name }}" 
                                             class="w-full h-48 object-cover">
                                        @if(!$food->is_available)
                                            <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                                Habis
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $food->name }}</h3>
                                            <span class="text-lg font-bold text-[#547792]">Rp {{ number_format($food->price, 0, ',', '.') }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $food->description }}</p>
                                        <p class="text-xs text-gray-500 mb-3">Oleh: {{ $food->seller->name ?? 'Toko' }}</p>
                                        <div class="flex justify-between items-center">
                                            @php
                                                $showActions = false;
                                                $isOwner = false;
                                                if (auth()->check()) {
                                                    $user = auth()->user();
                                                    $isOwner = $user->id === $food->seller_id;
                                                    $showActions = $user->role === 'admin' || 
                                                               (in_array($user->role, ['seller', 'mahasiswa']) && $isOwner);
                                                }
                                            @endphp
                                            
                                            @if($showActions)
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('foods.edit', $food) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('foods.toggle', $food) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-{{ $food->is_available ? 'yellow' : 'green' }}-600 hover:text-{{ $food->is_available ? 'yellow' : 'green' }}-800 text-sm font-medium">
                                                            {{ $food->is_available ? 'Tandai Habis' : 'Tersedia' }}
                                                        </button>
                                                    </form>
                                                    
                                                    @if($isOwner)
                                                    <form action="{{ route('foods.increment-delivery', $food) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-medium rounded-full transition-colors duration-200" title="Tambah jumlah pengantaran">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                            </svg>
                                                            {{ $food->delivery_count }}
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            @else
                                                <div></div>
                                            @endif
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $food->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $food->is_available ? 'Tersedia' : 'Habis' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $foods->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const foodCards = document.querySelectorAll('.bg-white.rounded-lg');
                
                foodCards.forEach(card => {
                    const foodName = card.querySelector('h3').textContent.toLowerCase();
                    if (foodName.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 