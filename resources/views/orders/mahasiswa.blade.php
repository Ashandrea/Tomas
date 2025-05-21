@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Pesanan Saya</h2>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors duration-200">
                Kembali ke Dashboard
            </a>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada pesanan</h3>
                <p class="mt-1 text-gray-500">Anda belum memiliki pesanan yang masuk.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-semibold text-lg text-gray-800">Pesanan #{{ $order->id }}</h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                              ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                              'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Pelanggan</p>
                                            <p class="text-sm text-gray-800">{{ $order->customer->name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Tanggal Pesanan</p>
                                            <p class="text-sm text-gray-800">{{ $order->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Total</p>
                                            <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Metode Pembayaran</p>
                                            <p class="text-sm text-gray-800">{{ ucfirst($order->payment_method) }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <p class="text-sm font-medium text-gray-500">Item Pesanan</p>
                                        <ul class="mt-1 space-y-1">
                                            @foreach($order->items as $item)
                                                <li class="text-sm text-gray-800">
                                                    {{ $item->quantity }}x {{ $item->food->name }} - Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="flex-shrink-0 space-y-2">
                                    <a href="{{ route('orders.show', $order) }}" class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Lihat Detail
                                    </a>
                                    
                                    @if($order->status === 'pending' || $order->status === 'accepted')
                                        <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="w-full">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="preparing">
                                            <button type="submit" class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                Proses Pesanan
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($order->status === 'preparing')
                                        <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="w-full">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="ready">
                                            <button type="submit" class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Tandai Siap Diantar
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
@endsection
