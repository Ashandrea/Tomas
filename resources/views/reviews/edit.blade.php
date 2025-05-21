<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('reviews.update', $review) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Order Details -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">{{ __('Order Details') }}</h3>
                            <div class="border rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="font-medium">{{ __('Order ID') }}</h4>
                                        <p class="text-gray-600">#{{ $review->order->id }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium">{{ __('Seller') }}</h4>
                                        <p class="text-gray-600">{{ $review->order->seller->name }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium">{{ __('Total Amount') }}</h4>
                                        <p class="text-gray-600">Rp {{ number_format($review->order->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium">{{ __('Order Date') }}</h4>
                                        <p class="text-gray-600">{{ $review->order->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="mb-6">
                            <label for="rating" class="block text-sm font-medium text-gray-700">{{ __('Rating') }}</label>
                            <div class="mt-1">
                                <select id="rating" name="rating" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>1 - Poor</option>
                                    <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>2 - Fair</option>
                                    <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>3 - Good</option>
                                    <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>4 - Very Good</option>
                                    <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>5 - Excellent</option>
                                </select>
                            </div>
                            @error('rating')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700">{{ __('Comment') }}</label>
                            <div class="mt-1">
                                <textarea id="comment" name="comment" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('comment', $review->comment) }}</textarea>
                            </div>
                            @error('comment')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('reviews.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Update Review') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 