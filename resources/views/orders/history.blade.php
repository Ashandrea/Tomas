<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-[#547792] leading-tight">
                {{ __('Riwayat Pesanan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @if($orders->isEmpty())
                        <div class="text-center py-12 space-y-4">
                            <div class="mx-auto w-24 h-24 bg-[#f0f6f9] rounded-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-[#547792]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">{{ __('Tidak ada pesanan') }}</h3>
                            <p class="text-gray-600 max-w-md mx-auto">
                                @if(auth()->user()->role === 'customer')
                                    {{ __('Daftar pesanan Anda kosong. Ayo mulai berbelanja!') }}
                                @elseif(auth()->user()->role === 'seller')
                                    {{ __('Toko Anda siap menerima pesanan. Tetap siap!') }}
                                @else
                                    {{ __('Belum ada penugasan pengiriman. Silakan periksa kembali nanti!') }}
                                @endif
                            </p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($orders as $order)
                                <div class="group relative bg-white border border-gray-100 rounded-xl p-6 hover:shadow-lg transition-all duration-300">
                            <!-- Order Header with Status and Date -->
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-3">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                                                    @switch($order->status)
                                                @case('delivered') bg-green-50 text-green-700 @break
                                                @case('cancelled') bg-red-50 text-red-700 @break
                                                @default bg-amber-50 text-amber-700
                                                    @endswitch">
                                                    @if($order->status === 'pending')
                                                        Menunggu
                                                    @elseif($order->status === 'processing')
                                                        Diproses
                                                    @elseif($order->status === 'on_delivery')
                                                        Dalam Pengiriman
                                                    @elseif($order->status === 'delivered')
                                                        Selesai
                                                    @elseif($order->status === 'cancelled')
                                                        Dibatalkan
                                                    @else
                                                        {{ ucfirst($order->status) }}
                                                    @endif
                                                </span>
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                        {{ $order->created_at->format('d M Y • H:i') }}
                                    </p>
                                            </div>

                                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                                            <a href="{{ route('orders.show', ['order' => $order->id]) }}" 
                                        class="px-4 py-2 bg-white border border-[#547792] text-[#547792] rounded-lg hover:bg-[#f0f6f9] transition-colors text-sm font-medium text-center">
                                                {{ __('Lihat Detail') }}
                                            </a>
                                            @if ($order->status === 'delivered' && !$order->review && auth()->user()->role !== 'courier')
                                                <a href="{{ route('reviews.create', ['order' => $order->id]) }}" 
                                                   class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm font-medium text-center">
                                            {{ __('Tulis Ulasan') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Order Content -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                            <!-- Order Items -->
                                <div class="lg:col-span-2">
                                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">{{ __('Item Pesanan') }}</h4>
                                            <div class="space-y-4">
                                                @foreach($order->items as $item)
                                            <div class="flex items-start gap-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                                <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border border-gray-100 bg-gray-50">
                                                    @if($item->food)
                                                        <x-food-image :food="$item->food" class="w-full h-full object-cover" />
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h5 class="text-sm font-medium text-gray-900 truncate">
                                                        {{ $item->food->name ?? __('Item Dihapus') }}
                                                    </h5>
                                                            <p class="text-sm text-gray-500">{{ $item->quantity }} × Rp {{ number_format($item->price_at_time, 0, ',', '.') }}</p>
                                                    @if($order->review && $item->food)
                                                        @php
                                                            $foodRating = null;
                                                            foreach ($order->reviews as $review) {
                                                                if ($review->food_id === $item->food_id) {
                                                                    $foodRating = $review->foodRatings->first();
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        @if($foodRating)
                                                            <div class="mt-1 flex items-center gap-1">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <svg class="w-4 h-4 {{ $i <= $foodRating->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                    </svg>
                                                                @endfor
                                                        </div>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    Rp {{ number_format($item->quantity * $item->price_at_time, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Order Summary -->
                                <div class="lg:col-span-1">
                                    <div class="bg-gray-50 rounded-lg p-5">
                                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">{{ __('Ringkasan Pesanan') }}</h4>
                                        
                                        <div class="space-y-3">
                                                @if($order->customer)
                                            <div class="flex items-start gap-3">
                                                <svg class="w-5 h-5 text-[#547792] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                <div>
                                                    <p class="text-xs font-medium text-gray-500">{{ __('Pelanggan') }}</p>
                                                    <p class="text-sm text-gray-900">{{ $order->customer->name ?? __('Pelanggan Dihapus') }}</p>
                                                </div>
                                                </div>
                                                @endif

                                                @if($order->seller)
                                            <div class="flex items-start gap-3">
                                                <svg class="w-5 h-5 text-[#547792] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                    </svg>
                                                <div>
                                                    <p class="text-xs font-medium text-gray-500">{{ __('Penjual') }}</p>
                                                    <p class="text-sm text-gray-900">{{ $order->seller->name ?? __('Penjual Dihapus') }}</p>
                                                </div>
                                                </div>
                                                @endif

                                                @if($order->courier)
                                            <div class="flex items-start gap-3">
                                                <svg class="w-5 h-5 text-[#547792] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                <div>
                                                    <p class="text-xs font-medium text-gray-500">{{ __('Kurir') }}</p>
                                                    <p class="text-sm text-gray-900">{{ $order->courier->name ?? __('Kurir Dihapus') }}</p>
                                                </div>
                                                </div>
                                                @endif

                                            <div class="pt-3 mt-3 border-t border-gray-200">
                                                <div class="flex justify-between items-center">
                                                    <p class="text-sm font-medium text-gray-500">{{ __('Subtotal') }}</p>
                                                    <p class="text-sm text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                                </div>
                                                <div class="flex justify-between items-center mt-1">
                                                    <p class="text-sm font-medium text-gray-500">{{ __('Ongkos Kirim') }}</p>
                                                    <p class="text-sm text-gray-900">
                                                        @if(auth()->user()->role === 'courier')
                                                            Rp 5.000
                                                        @else
                                                            Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-200">
                                                    <p class="text-base font-semibold text-gray-900">{{ __('Total') }}</p>
                                                    <p class="text-base font-semibold text-gray-900">
                                                        @if(auth()->user()->role === 'courier')
                                                            Rp {{ number_format($order->total_amount + 5000, 0, ',', '.') }}
                                                        @else
                                                            Rp {{ number_format($order->total_amount + $order->delivery_fee, 0, ',', '.') }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delivery Rating Section -->
                                    @if($order->review)
                                        <div class="mt-6 bg-gray-50 rounded-lg p-5">
                                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-4">{{ __('Ulasan Pengiriman') }}</h4>
                                            @php
                                                $courierReview = $order->reviews->where('courier_id', '!=', null)->first();
                                            @endphp
                                            @if($courierReview)
                                                <div class="flex items-center gap-1 mb-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-5 h-5 {{ $i <= $courierReview->courier_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                @if($courierReview->courier_comment)
                                                    <p class="text-sm text-gray-700 italic">"{{ $courierReview->courier_comment }}"</p>
                                                @endif
                                            @else
                                                <p class="text-sm text-gray-500">Belum ada ulasan pengiriman</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                        </div>

                        <!-- Pagination -->
                <div class="mt-8">
                <x-pagination :paginator="$orders" />
                </div>
                    @endif
        </div>
    </div>
</x-app-layout>
