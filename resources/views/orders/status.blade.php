<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ __('Status Pesanan') }} #{{ $order->id }}
            </h2>
            <span class="px-3 py-1 bg-indigo-600 text-white rounded-full text-sm font-medium shadow-sm">
                {{ ucfirst(Auth::user()->role) }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 md:p-8">
                    <!-- Order Details Card -->
                    <div class="bg-gray-100 rounded-xl p-6 mb-8 border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('Detail Pesanan') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">{{ __('Pelanggan') }}</p>
                                    <p class="text-base font-medium text-gray-900 mt-1">{{ $order->customer->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">{{ __('Penjual') }}</p>
                                    <p class="text-base font-medium text-gray-900 mt-1">{{ $order->seller->name }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">{{ __('Lokasi Pengiriman') }}</p>
                                    <p class="text-base font-medium text-gray-900 mt-1">{{ $order->delivery_location }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-700">{{ __('Total Harga') }}</p>
                                    <p class="text-lg font-bold text-indigo-700 mt-1">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Card -->
                    <div class="bg-gray-100 rounded-xl p-6 mb-8 border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('Item Pesanan') }}</h3>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-xs hover:shadow-sm transition-shadow duration-150">
                                    <div class="flex justify-between">
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $item->food->name }}</h4>
                                            <div class="mt-2 space-y-1">
                                                <p class="text-sm font-medium text-gray-700">{{ __('Jumlah:') }} <span class="text-gray-900">{{ $item->quantity }}</span></p>
                                                <p class="text-sm font-medium text-gray-700">{{ __('Harga:') }} <span class="text-gray-900">Rp {{ number_format($item->price_at_time, 0, ',', '.') }}</span></p>
                                                @if($item->notes)
                                                    <p class="text-sm font-medium text-gray-700">{{ __('Catatan:') }} <span class="text-gray-900 font-normal">{{ $item->notes }}</span></p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-sm font-medium text-gray-500">
                                            {{ $item->created_at->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Status Timeline Card -->
                    <div class="bg-gray-100 rounded-xl p-6 mb-8 border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">{{ __('Status Pesanan') }}</h3>
                        <div class="relative">
                            <!-- Timeline line -->
                            <div class="absolute left-4 top-0 h-full w-1 bg-gray-300"></div>
                            
                            <!-- Timeline items -->
                            <div class="space-y-8">
                                <!-- Pending -->
                                <div class="relative flex items-start">
                                    <div class="absolute left-4 -ml-2 mt-1.5 w-4 h-4 rounded-full {{ $order->status === 'pending' ? 'bg-yellow-500 ring-4 ring-yellow-100' : ($order->status !== 'pending' ? 'bg-green-600' : 'bg-gray-400') }}"></div>
                                    <div class="ml-10">
                                        <h4 class="text-base font-bold text-gray-900">Pesanan dibuat</h4>
                                        <p class="mt-1 text-sm font-medium text-gray-700">{{ __('Menunggu kurir menerima pesanan') }}</p>
                                        <p class="mt-1 text-xs font-medium text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>

                                <!-- Accepted -->
                                <div class="relative flex items-start">
                                    <div class="absolute left-4 -ml-2 mt-1.5 w-4 h-4 rounded-full {{ $order->status === 'accepted' ? 'bg-yellow-500 ring-4 ring-yellow-100' : ($order->status !== 'pending' && $order->status !== 'accepted' ? 'bg-green-600' : 'bg-gray-400') }}"></div>
                                    <div class="ml-10">
                                        <h4 class="text-base font-bold text-gray-900">Pesanan diterima kurir</h4>
                                        <p class="mt-1 text-sm font-medium text-gray-700">{{ __('Kurir telah menerima pesanan') }}</p>
                                        @if($order->status !== 'pending')
                                            <p class="mt-1 text-xs font-medium text-gray-500">{{ $order->updated_at->format('d M Y H:i') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Preparing -->
                                <div class="relative flex items-start">
                                    <div class="absolute left-4 -ml-2 mt-1.5 w-4 h-4 rounded-full {{ $order->status === 'preparing' ? 'bg-yellow-500 ring-4 ring-yellow-100' : ($order->status === 'ready' || $order->status === 'picked_up' || $order->status === 'delivered' ? 'bg-green-600' : 'bg-gray-400') }}"></div>
                                    <div class="ml-10">
                                        <h4 class="text-base font-bold text-gray-900">Menyiapkan makanan</h4>
                                        <p class="mt-1 text-sm font-medium text-gray-700">{{ __('Memesan makanan dari penjual') }}</p>
                                    </div>
                                </div>

                                <!-- Ready -->
                                <div class="relative flex items-start">
                                    <div class="absolute left-4 -ml-2 mt-1.5 w-4 h-4 rounded-full {{ $order->status === 'ready' ? 'bg-yellow-500 ring-4 ring-yellow-100' : ($order->status === 'picked_up' || $order->status === 'delivered' ? 'bg-green-600' : 'bg-gray-400') }}"></div>
                                    <div class="ml-10">
                                        <h4 class="text-base font-bold text-gray-900">Siap diambil</h4>
                                        <p class="mt-1 text-sm font-medium text-gray-700">{{ __('Makanan siap untuk diambil') }}</p>
                                    </div>
                                </div>

                                <!-- Picked Up -->
                                <div class="relative flex items-start">
                                    <div class="absolute left-4 -ml-2 mt-1.5 w-4 h-4 rounded-full {{ $order->status === 'picked_up' ? 'bg-yellow-500 ring-4 ring-yellow-100' : ($order->status === 'delivered' ? 'bg-green-600' : 'bg-gray-400') }}"></div>
                                    <div class="ml-10">
                                        <h4 class="text-base font-bold text-gray-900">Dalam perjalanan</h4>
                                        <p class="mt-1 text-sm font-medium text-gray-700">{{ __('Pesanan telah diambil dari penjual') }}</p>
                                    </div>
                                </div>

                                <!-- Delivered -->
                                <div class="relative flex items-start">
                                    <div class="absolute left-4 -ml-2 mt-1.5 w-4 h-4 rounded-full {{ $order->status === 'delivered' ? 'bg-green-600 ring-4 ring-green-100' : 'bg-gray-400' }}"></div>
                                    <div class="ml-10">
                                        <h4 class="text-base font-bold text-gray-900">Terkirim</h4>
                                        <p class="mt-1 text-sm font-medium text-gray-700">{{ __('Pesanan telah sampai ke pelanggan') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8">
                        <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:space-x-4 justify-end">
                            @if($order->status === 'pending')
                                <form action="{{ route('orders.status', $order) }}" method="POST" class="w-full md:w-auto">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="accepted">
                                    <input type="hidden" name="courier_id" value="{{ auth()->id() }}">
                                    <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Terima Pesanan') }}
                                    </button>
                                </form>
                            @elseif($order->status === 'accepted')
                                @if(auth()->user()->role === 'courier')
                                <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')" class="w-full md:w-auto">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        {{ __('Batalkan Pesanan') }}
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="w-full md:w-auto">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="preparing">
                                    <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Pesan dari Penjual') }}
                                    </button>
                                </form>
                            @elseif($order->status === 'preparing')
                                @if(auth()->user()->role === 'courier')
                                <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')" class="w-full md:w-auto">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        {{ __('Batalkan Pesanan') }}
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="w-full md:w-auto">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="ready">
                                    <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Tandai Sudah Siap') }}
                                    </button>
                                </form>
                            @elseif($order->status === 'ready')
                                <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="w-full md:w-auto">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="picked_up">
                                    <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Ambil dari Penjual') }}
                                    </button>
                                </form>
                            @elseif($order->status === 'picked_up')
                                <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="w-full md:w-auto">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="delivered">
                                    <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Tandai Sudah Dikirim') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>