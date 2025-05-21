<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dasbor Kurir') }}
            </h2>
            <div class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                {{ ucfirst(Auth::user()->role) }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Pesanan Tersedia') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $pendingOrders->count() }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-indigo-50 text-indigo-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Harus Diambil') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $availableOrders->count() }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-yellow-50 text-yellow-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ __('Harus Dikirim') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 mt-1">{{ $activeDeliveries->count() }}</p>
                        </div>
                        <div class="p-3 rounded-lg bg-green-50 text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Orders -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Pesanan Tersedia') }}
                    </h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @if($pendingOrders->isEmpty())
                        <div class="p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-3 text-gray-500">{{ __('Tidak ada pesanan yang tersedia saat ini.') }}</p>
                        </div>
                    @else
                        @foreach($pendingOrders as $order)
                            <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-baseline gap-2">
                                            <h4 class="font-medium text-lg text-gray-900">{{ __('Pesanan #') }}{{ $order->id }}</h4>
                                            <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-800">{{ ucfirst($order->status) }}</span>
                                        </div>
                                        
                                        <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-500">{{ __('Pelanggan') }}</p>
                                                <p class="font-medium">{{ $order->customer->name }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">{{ __('Penjual') }}</p>
                                                <p class="font-medium">{{ $order->seller->name }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">{{ __('Lokasi Pengiriman') }}</p>
                                                <p class="font-medium">{{ $order->delivery_location }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">{{ __('Total') }}</p>
                                                <p class="font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <p class="text-sm font-medium text-gray-700 mb-2">{{ __('Item Pesanan:') }}</p>
                                            <ul class="space-y-1">
                                                @foreach($order->items as $item)
                                                    <li class="flex justify-between text-sm">
                                                        <span>{{ $item->quantity }}x {{ $item->food ? $item->food->name : 'Item Dihapus' }}</span>
                                                        <span class="text-gray-500">@ Rp {{ number_format($item->price_at_time, 0, ',', '.') }}</span>
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
                                                <button type="submit" class="w-full md:w-auto flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ __('Terima Pesanan') }}
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('orders.status', $order) }}" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                {{ __('Lihat Status') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Orders to Pick Up -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Pesanan yang Harus Diambil') }}
                    </h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @if($availableOrders->isEmpty())
                        <div class="p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-3 text-gray-500">{{ __('Tidak ada pesanan yang harus diambil saat ini.') }}</p>
                        </div>
                    @else
                        @foreach($availableOrders as $order)
                            <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-baseline gap-2">
                                            <h4 class="font-medium text-lg text-gray-900">{{ __('Pesanan #') }}{{ $order->id }}</h4>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($order->status === 'accepted') bg-yellow-100 text-yellow-800
                                                @elseif($order->status === 'preparing') bg-blue-100 text-blue-800
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                        
                                        <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-500">{{ __('Pelanggan') }}</p>
                                                <p class="font-medium">{{ $order->customer->name }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">{{ __('Penjual') }}</p>
                                                <p class="font-medium">{{ $order->seller->name }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">{{ __('Total') }}</p>
                                                <p class="font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex-shrink-0">
                                        @if($order->status === 'accepted')
                                            <form action="{{ route('orders.status', $order) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="preparing">
                                                <button type="submit" class="w-full md:w-auto flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    {{ __('Ambil dari Penjual') }}
                                                </button>
                                            </form>
                                        @elseif($order->status === 'preparing')
                                            <form action="{{ route('orders.status', $order) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="ready">
                                                <button type="submit" class="w-full md:w-auto flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    {{ __('Tandai Sudah Diambil') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Orders to Deliver -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1V5a1 1 0 00-1-1H3zM3 5h2v2H3V5zm0 4h2v2H3V9zm0 4h2v2H3v-2zm12-8h2v2h-2V5zm0 4h2v2h-2V9zm0 4h2v2h-2v-2z" />
                        </svg>
                        {{ __('Pesanan yang Harus Dikirim') }}
                    </h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @if($activeDeliveries->isEmpty())
                        <div class="p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-3 text-gray-500">{{ __('Tidak ada pesanan yang harus dikirim saat ini.') }}</p>
                        </div>
                    @else
                        @foreach($activeDeliveries as $order)
                            <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-baseline gap-2">
                                            <h4 class="font-medium text-lg text-gray-900">{{ __('Pesanan #') }}{{ $order->id }}</h4>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($order->status === 'ready') bg-blue-100 text-blue-800
                                                @elseif($order->status === 'picked_up') bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                        
                                        <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-500">{{ __('Pelanggan') }}</p>
                                                <p class="font-medium">{{ $order->customer->name }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">{{ __('Penjual') }}</p>
                                                <p class="font-medium">{{ $order->seller->name }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">{{ __('Lokasi Pengiriman') }}</p>
                                                <p class="font-medium">{{ $order->delivery_location }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex-shrink-0">
                                        @if($order->status === 'ready')
                                            <form action="{{ route('orders.status', $order) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="picked_up">
                                                <button type="submit" class="w-full md:w-auto flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    {{ __('Ambil Pesanan') }}
                                                </button>
                                            </form>
                                        @elseif($order->status === 'picked_up')
                                            <form action="{{ route('orders.status', $order) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="delivered">
                                                <button type="submit" class="w-full md:w-auto flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    {{ __('Tandai Terkirim') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>