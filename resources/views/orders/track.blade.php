<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lacak Pesanan #') }}{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Order Status Timeline -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">{{ __('Status Pesanan') }}</h3>
                        <div class="relative">
                            <div class="absolute left-4 top-0 h-full w-0.5 bg-gray-200"></div>
                            
                            <!-- Pending -->
                            <div class="relative flex items-center mb-8">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-blue-600">Pesanan dibuat</h4>
                                    <p class="text-sm text-gray-500">{{ __('Menunggu konfirmasi penjual') }}</p>
                                </div>
                            </div>

                            <!-- Accepted -->
                            <div class="relative flex items-center mb-8">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-400">Pesanan diterima kurir</h4>
                                    <p class="text-sm text-gray-400">{{ __('Penjual telah menerima pesanan Anda') }}</p>
                                </div>
                            </div>

                            <!-- Preparing -->
                            <div class="relative flex items-center mb-8">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-400">Menyiapkan makanan</h4>
                                    <p class="text-sm text-gray-400">{{ __('Penjual sedang menyiapkan pesanan Anda') }}</p>
                                </div>
                            </div>

                            <!-- Ready -->
                            <div class="relative flex items-center mb-8">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-400">Siap diambil</h4>
                                    <p class="text-sm text-gray-400">{{ __('Pesanan siap untuk dikirim') }}</p>
                                </div>
                            </div>

                            <!-- Picked Up -->
                            <div class="relative flex items-center mb-8">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-400">Dalam perjalanan</h4>
                                    <p class="text-sm text-gray-400">{{ __('Kurir sedang mengantar pesanan Anda') }}</p>
                                </div>
                            </div>

                            <!-- Delivered -->
                            <div class="relative flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-400">{{ __('Terkirim') }}</h4>
                                    <p class="text-sm text-gray-400">{{ __('Pesanan telah sampai') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">{{ __('Detail Pesanan') }}</h3>
                        <div class="border rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="font-medium">{{ __('Penjual') }}</h4>
                                    <p class="text-gray-600">{{ $order->seller->name }}</p>
                                </div>
                                <div>
                                    <h4 class="font-medium">{{ __('Lokasi Pengiriman') }}</h4>
                                    <p class="text-gray-600">{{ $order->delivery_location }}</p>
                                </div>
                                <div>
                                    <h4 class="font-medium">{{ __('Kurir') }}</h4>
                                    <p class="text-gray-600">{{ $order->courier ? $order->courier->name : __('Belum ditugaskan') }}</p>
                                </div>
                                <div>
                                    <h4 class="font-medium">{{ __('Total Pembayaran') }}</h4>
                                    <p class="text-gray-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
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