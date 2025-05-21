<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ __('Dashboard Kurir') }}
            </h2>
            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Available Orders -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ __('Pesanan Tersedia') }}</h3>
                            <p class="text-gray-500 text-sm">{{ __('Pesanan yang bisa Anda terima') }}</p>
                        </div>
                    </div>
                    
                    @if($pendingOrders->isEmpty())
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4 class="mt-3 text-lg font-medium text-gray-700">{{ __('Tidak ada pesanan') }}</h4>
                            <p class="mt-1 text-gray-500">{{ __('Tidak ada pesanan yang tersedia saat ini') }}</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($pendingOrders as $order)
                                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">
                                    <div class="p-5">
                                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="font-semibold text-lg text-gray-800">{{ __('Order #') }}{{ $order->id }}</h4>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </div>
                                                
                                                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">{{ __('Pelanggan') }}</p>
                                                        <p class="text-sm text-gray-800">{{ $order->customer->name }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">{{ __('Penjual') }}</p>
                                                        <p class="text-sm text-gray-800">{{ $order->seller->name }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">{{ __('Lokasi Pengiriman') }}</p>
                                                        <p class="text-sm text-gray-800">{{ $order->delivery_location }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">{{ __('Total') }}</p>
                                                        <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-4">
                                                    <p class="text-sm font-medium text-gray-500">{{ __('Item Pesanan') }}</p>
                                                    <ul class="mt-1 space-y-1">
                                                        @foreach($order->items as $item)
                                                            <li class="flex justify-between text-sm text-gray-700">
                                                                <span>{{ $item->quantity }}x {{ $item->food->name }}</span>
                                                                <span>Rp {{ number_format($item->price_at_time, 0, ',', '.') }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <div class="flex-shrink-0">
                                                @if($order->status === 'pending')
                                                    <form action="{{ route('orders.updateStatus', $order) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <input type="hidden" name="courier_id" value="{{ auth()->id() }}">
                                                        <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                                                            {{ __('Terima Pesanan') }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('orders.status', $order) }}" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                                                        {{ __('Lihat Status') }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Orders to Pick Up -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ __('Pesanan yang Harus Diambil') }}</h3>
                            <p class="text-gray-500 text-sm">{{ __('Pesanan yang perlu Anda ambil dari penjual') }}</p>
                        </div>
                    </div>
                    
                    @if($availableOrders->isEmpty())
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4 class="mt-3 text-lg font-medium text-gray-700">{{ __('Tidak ada pesanan') }}</h4>
                            <p class="mt-1 text-gray-500">{{ __('Tidak ada pesanan yang perlu diambil saat ini') }}</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($availableOrders as $order)
                                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">
                                    <div class="p-5">
                                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="font-semibold text-lg text-gray-800">{{ __('Order #') }}{{ $order->id }}</h4>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                        {{ $order->status === 'accepted' ? 'bg-blue-100 text-blue-800' : 
                                                           ($order->status === 'preparing' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800') }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </div>
                                                
                                                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">{{ __('Pelanggan') }}</p>
                                                        <p class="text-sm text-gray-800">{{ $order->customer->name }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">{{ __('Penjual') }}</p>
                                                        <p class="text-sm text-gray-800">{{ $order->seller->name }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">{{ __('Lokasi Pengiriman') }}</p>
                                                        <p class="text-sm text-gray-800">{{ $order->delivery_location }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">{{ __('Total') }}</p>
                                                        <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="flex-shrink-0">
                                                @if($order->status === 'accepted')
                                                    <form action="{{ route('orders.status', $order) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="preparing">
                                                        <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                                                            {{ __('Ambil dari Penjual') }}
                                                        </button>
                                                    </form>
                                                @elseif($order->status === 'preparing')
                                                    <form action="{{ route('orders.status', $order) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="ready">
                                                        <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                                                            {{ __('Tandai Sudah Diambil') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Orders to Deliver -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ __('Pesanan yang Harus Dikirim') }}</h3>
                            <p class="text-gray-500 text-sm">{{ __('Pesanan yang perlu Anda antarkan ke pelanggan') }}</p>
                        </div>
                    </div>
                    
                    @if($activeDeliveries->isEmpty())
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h4 class="mt-3 text-lg font-medium text-gray-700">{{ __('Tidak ada pesanan') }}</h4>
                            <p class="mt-1 text-gray-500">{{ __('Tidak ada pesanan yang perlu dikirim saat ini') }}</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($activeDeliveries as $order)
                                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">
                                    <div class="p-5">
                                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="font-semibold text-lg text-gray-800">{{ __('Order #') }}{{ $order->id }}</h4>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                        {{ $order->status === 'ready' ? 'bg-green-100 text-green-800' : 
                                                           ($order->status === 'picked_up' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800') }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </div>
                                                
                                                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">{{ __('Pelanggan') }}</p>
                                                        <p class="text-sm text-gray-800">{{ $order->customer->name }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">{{ __('Penjual') }}</p>
                                                        <p class="text-sm text-gray-800">{{ $order->seller->name }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">{{ __('Lokasi Pengiriman') }}</p>
                                                        <p class="text-sm text-gray-800">{{ $order->delivery_location }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-500">{{ __('Status') }}</p>
                                                        <p class="text-sm text-gray-800">{{ ucfirst($order->status) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="flex-shrink-0">
                                                @if($order->status === 'ready')
                                                    <form action="{{ route('orders.status', $order) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="picked_up">
                                                        <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                                                            {{ __('Ambil dari Penjual') }}
                                                        </button>
                                                    </form>
                                                @elseif($order->status === 'picked_up')
                                                    <form action="{{ route('orders.status', $order) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="delivered">
                                                        <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                                                            {{ __('Tandai Terkirim') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
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