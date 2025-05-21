<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($orders->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('No orders yet') }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Get started by placing your first order.') }}</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($orders as $order)
                                <div class="border rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">{{ __('Order #') }}{{ $order->id }}</h3>
                                            <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->status === 'accepted' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $order->status === 'preparing' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $order->status === 'ready' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->status === 'picked_up' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                                {{ $order->status === 'delivered' ? 'bg-gray-100 text-gray-800' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500">{{ __('Seller') }}</h4>
                                                <p class="mt-1 text-sm text-gray-900">{{ $order->seller->name }}</p>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-500">{{ __('Total Amount') }}</h4>
                                                <p class="mt-1 text-sm text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 flex justify-end space-x-4">
                                        <a href="{{ route('orders.show', $order) }}" 
                                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#547792] hover:bg-[#47687d] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#547792]">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ __('View Details') }}
                                        </a>
                                        <a href="{{ route('orders.track', $order) }}" 
                                           class="inline-flex items-center px-4 py-2 border border-[#547792] rounded-md text-sm font-medium text-[#547792] hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#547792]">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </svg>
                                            {{ __('Track Order') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 