<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beri Nilai Pesanan #:id', ['id' => $order->id]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-8 text-gray-900">
                    <form id="reviewForm" action="{{ route('reviews.store', $order) }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Food Items Rating Section -->
                        <div class="border-b border-gray-200 pb-8">
                            <h3 class="text-lg font-semibold mb-6">{{ __('Penilaian Makanan') }}</h3>
                            
                            @foreach($order->items as $item)
                                <div class="mb-8 last:mb-0">
                                    <div class="flex items-start gap-4">
                                        <!-- Food Image -->
                                        <div class="w-24 h-24 flex-shrink-0">
                                            @if(isset($item->food) && $item->food->image)
                                                <img src="{{ Storage::url($item->food->image) }}" 
                                                     alt="{{ $item->food->name }}" 
                                                     class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <div class="w-full h-full bg-gray-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $item->food->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $item->quantity }} × {{ number_format($item->price_at_time, 0, ',', '.') }}</p>
                                            
                                            <!-- Food Rating -->
                                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    {{ __('Beri nilai item ini') }}
                                    <span class="text-red-500">*</span>
                                </label>
                                                <div class="flex items-center gap-1 mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                                                class="food-rating-{{ $item->food->id }}-star w-8 h-8 cursor-pointer transition-all duration-200 transform hover:scale-110"
                                            data-rating="{{ $i }}"
                                                                onclick="setFoodRating('{{ $item->food->id }}', {{ $i }})"
                                                                aria-label="Rate {{ $i }} star">
                                            <svg class="w-full h-full text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37-2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.01 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z" />
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                                <div class="flex justify-between text-xs text-gray-400 px-1">
                                                    <span>{{ __('Buruk') }}</span>
                                                    <span>{{ __('Sangat Baik') }}</span>
                                                </div>
                                                <input type="hidden" 
                                                       name="food_ratings[{{ $item->food->id }}][rating]" 
                                                       id="food-rating-{{ $item->food->id }}" 
                                                       required>
                                                @error("food_ratings.{$item->food->id}.rating")
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                                            <!-- Food Comment -->
                                            <div class="mt-3">
                                                <label for="food-comment-{{ $item->food->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                                    {{ __('Ulasan Anda (opsional)') }}
                                </label>
                                                <textarea id="food-comment-{{ $item->food->id }}" 
                                                        name="food_ratings[{{ $item->food->id }}][comment]" 
                                                        rows="2" 
                                                        class="block w-full rounded-lg border-gray-200 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2 text-sm transition-all duration-300"
                                                        placeholder="{{ __('Bagikan pendapat Anda tentang item ini...') }}"></textarea>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Delivery Rating Section -->
                        @if($order->courier)
                        <div class="border-b border-gray-200 pb-8">
                            <h3 class="text-lg font-semibold mb-6">{{ __('Penilaian Pengiriman') }}</h3>
                            
                            <!-- Star Rating -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ __('Bagaimana layanan pengirimannya?') }}
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center gap-2">
                                        @for($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                            class="courier-star w-10 h-10 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            data-rating="{{ $i }}"
                                            onclick="setCourierRating({{ $i }})">
                                            <svg class="w-full h-full text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                    <div class="flex justify-between text-xs text-gray-400 px-1 mt-1">
                                        <span>{{ __('Buruk') }}</span>
                                        <span>{{ __('Sangat Baik') }}</span>
                                </div>
                                <input type="hidden" name="courier_rating" id="courier_rating" required>
                                @error('courier_rating')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Comment -->
                            <div>
                                <label for="courier_comment" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Komentar tentang pengiriman (opsional)') }}
                                </label>
                                <textarea
                                    id="courier_comment"
                                    name="courier_comment"
                                    rows="3"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    placeholder="{{ __('Ceritakan pengalaman pengiriman Anda...') }}"
                                >{{ old('courier_comment') }}</textarea>
                                </div>
                            </div>
                        @endif

                        <!-- Submit Button -->
                        <div class="pt-8">
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Kirim Penilaian') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function setFoodRating(foodId, rating) {
            // Update hidden input
            document.getElementById(`food-rating-${foodId}`).value = rating;
            
            // Update star colors
            const stars = document.querySelectorAll(`.food-rating-${foodId}-star svg`);
            stars.forEach((star, index) => {
                star.classList.remove('text-yellow-400', 'text-gray-300');
                star.classList.add(index < rating ? 'text-yellow-400' : 'text-gray-300');
            });
            
            validateForm();
        }

        function setCourierRating(rating) {
            // Update hidden input
            document.getElementById('courier_rating').value = rating;
            
            // Update star colors
            const stars = document.querySelectorAll('.courier-star svg');
            stars.forEach((star, index) => {
                star.classList.remove('text-yellow-400', 'text-gray-300');
                star.classList.add(index < rating ? 'text-yellow-400' : 'text-gray-300');
            });
            
            validateForm();
        }

        function validateForm() {
            const submitButton = document.querySelector('button[type="submit"]');
            const foodRatings = document.querySelectorAll('input[name^="food_ratings"][name$="[rating]"]');
            const courierRatingInput = document.getElementById('courier_rating');
            
            let isValid = true;
            
            // Check all food ratings
            foodRatings.forEach(input => {
                if (!input.value) {
                    isValid = false;
                }
            });
            
            // Check courier rating if it exists
            if (courierRatingInput && !courierRatingInput.value) {
                isValid = false;
            }

            submitButton.disabled = !isValid;
            submitButton.classList.toggle('opacity-50', !isValid);
            submitButton.classList.toggle('cursor-not-allowed', !isValid);
        }

        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            const foodRatings = document.querySelectorAll('input[name^="food_ratings"][name$="[rating]"]');
            const courierRatingInput = document.getElementById('courier_rating');
            
            let isValid = true;
            
            // Check all food ratings
            foodRatings.forEach(input => {
                if (!input.value) {
                    isValid = false;
                }
            });
            
            // Check courier rating if it exists
            if (courierRatingInput && !courierRatingInput.value) {
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                alert('Please provide all required ratings before submitting.');
                return false;
            }

            // Disable the submit button to prevent double submission
            const submitButton = document.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            return true;
        });

        // Set initial validation state
        document.addEventListener('DOMContentLoaded', function() {
            validateForm();
        });
    </script>
    @endpush
</x-app-layout> 