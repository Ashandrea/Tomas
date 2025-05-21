@if($foods->isEmpty())
    <div class="text-center py-8">
        <div class="inline-block bg-[#f0f6f9] p-4 rounded-full mb-4">
            <svg class="w-12 h-12 text-[#547792]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <p class="text-gray-600 mb-4">{{ __('Tidak ada makanan yang sesuai dengan pencarian Anda') }}</p>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-6">
        @foreach($foods as $food)
            <div class="group relative bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 food-card">
                <x-food-image :food="$food" class="h-48 rounded-t-xl group-hover:scale-105 transition-all duration-300" />

                <div class="p-4">
                    <h4 class="text-lg font-semibold text-gray-800 truncate mb-2">{{ $food->name }}</h4>
                    <p class="text-sm text-gray-500 mb-2">{{ __('Dari ') }}<span class="font-medium">{{ $food->seller->name }}</span></p>
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-xl font-bold text-[#547792]">Rp {{ number_format($food->price, 0, ',', '.') }}</p>
                        <div class="flex items-center bg-pink-100 px-2 py-1 rounded-full">
                            <svg class="w-4 h-4 text-red-800" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37-2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.01 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z"/>
                            </svg>
                            <span class="text-sm font-semibold text-red-800 ml-1">{{ number_format($food->average_rating ?? 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="addToCart(event, '{{ $food->id }}', '{{ $food->name }}', {{ $food->price }})"
                                class="w-12 h-10 bg-[#547792] text-white rounded-lg hover:bg-[#47687d] transition-all flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        <button onclick="orderSingleItem(event, '{{ $food->id }}', '{{ $food->name }}', {{ $food->price }})"
                                class="flex-1 text-center px-4 py-2.5 bg-[#547792] text-white rounded-lg hover:bg-[#47687d] transition-all font-medium flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            {{ __('Pesan') }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        <x-pagination :paginator="$foods" />
    </div>
@endif 