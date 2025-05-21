<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan #') }}{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Order Status -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Status Pesanan</h3>
                        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $order->status === 'accepted' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $order->status === 'preparing' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $order->status === 'ready' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->status === 'picked_up' ? 'bg-indigo-100 text-indigo-800' : '' }}
                            {{ $order->status === 'delivered' ? 'bg-gray-100 text-gray-800' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            @switch($order->status)
                                @case('pending')
                                    Menunggu Konfirmasi
                                    @break
                                @case('accepted')
                                    Pesanan Diterima
                                    @break
                                @case('preparing')
                                    Sedang Disiapkan
                                    @break
                                @case('ready')
                                    Siap Diambil
                                    @break
                                @case('picked_up')
                                    Sedang Dikirim
                                    @break
                                @case('delivered')
                                    Telah Sampai
                                    @break
                                @case('cancelled')
                                    Dibatalkan
                                    @break
                                @default
                                    {{ ucfirst($order->status) }}
                            @endswitch
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Item Pesanan</h3>
                        <div class="border rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @foreach($order->items as $item)
                                        @php
                                            $itemSubtotal = $item->price_at_time * $item->quantity;
                                            $subtotal += $itemSubtotal;
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($item->food)
                                                            <x-food-image :food="$item->food" class="h-10 w-10 rounded-full" />
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $item->food ? $item->food->name : 'Item tidak tersedia' }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $item->food && $item->food->seller ? $item->food->seller->name : 'Penjual tidak diketahui' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Rp {{ number_format($item->price_at_time, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Subtotal</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Biaya Pengiriman</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            @if(auth()->user()->role === 'courier')
                                                Rp 5.000
                                            @else
                                                Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-500">Total</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            @if(auth()->user()->role === 'courier')
                                                Rp {{ number_format($order->total_amount + 5000, 0, ',', '.') }}
                                            @else
                                                Rp {{ number_format($order->total_amount + $order->delivery_fee, 0, ',', '.') }}
                                            @endif
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Order Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Informasi Pesanan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-medium">Pelanggan</h4>
                                <p class="text-gray-600">{{ $order->customer->name }}</p>
                                <p class="text-gray-600">{{ $order->customer->phone }}</p>
                            </div>
                            <div>
                                <h4 class="font-medium">Lokasi Pengiriman</h4>
                                <p class="text-gray-600">{{ $order->delivery_location }}</p>
                            </div>
                            <div>
                                <h4 class="font-medium">Penjual</h4>
                                <p class="text-gray-600">{{ $order->seller->name }}</p>
                                <p class="text-gray-600">{{ $order->seller->phone }}</p>
                            </div>
                            <div>
                                <h4 class="font-medium">Kurir</h4>
                                <p class="text-gray-600">{{ $order->courier ? $order->courier->name : 'Belum ditugaskan' }}</p>
                                @if($order->courier)
                                    <p class="text-gray-600">{{ $order->courier->phone }}</p>
                                @endif
                            </div>
                            @if($order->notes)
                            <div class="md:col-span-2">
                                <h4 class="font-medium">Catatan</h4>
                                <p class="text-gray-600 whitespace-pre-line">{{ $order->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-4">
                        @if($order->status === 'pending' && auth()->user()->id === $order->customer_id)
                            <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Batalkan Pesanan
                                </button>
                            </form>
                        @endif

                        @if($order->status === 'delivered' && auth()->user()->id === $order->customer_id && !$order->review)
                            <a href="{{ route('reviews.create', $order) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Tulis Ulasan
                            </a>
                        @endif

                        <a href="{{ route('orders.track', $order) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Lacak Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('clearCart'))
    <script>
        // Clear the cart when the page loads if clearCart session flag is set
        document.addEventListener('DOMContentLoaded', function() {
            localStorage.removeItem('cart');
        });
    </script>
    @endif
</x-app-layout>