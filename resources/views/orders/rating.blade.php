<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rate Order #:id', ['id' => $order->id]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-8 text-gray-900 space-y-10">
                    <form id="review-form" action="{{ route('orders.submitRating', ['order' => $order->id]) }}" method="POST">
                        @csrf
                        
                        <!-- Food Items Rating Section -->
                        <div class="border-b border-gray-100 pb-10">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="p-3 bg-indigo-50 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">{{ __('Rate Your Food Items') }}</h3>
                            </div>
                            
                            @foreach($order->items as $item)
                                <div class="mb-10 p-6 bg-gray-50 rounded-xl">
                                    <div class="flex items-start gap-4">
                                        @if($item->food->image)
                                            <img src="{{ Storage::url($item->food->image) }}" alt="{{ $item->food->name }}" class="w-20 h-20 object-cover rounded-lg">
                                        @else
                                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $item->food->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $item->quantity }} × {{ number_format($item->price_at_time, 0, ',', '.') }}</p>
                                            
                                            <!-- Food Rating -->
                                            <div class="mt-3">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    {{ __('Rate this item') }}
                                                </label>
                                                <div class="flex items-center gap-1 mb-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <button type="button" 
                                                                class="food-rating-{{ $item->id }}-star w-8 h-8 cursor-pointer transition-all duration-200 transform hover:scale-110"
                                                                data-rating="{{ $i }}"
                                                                onclick="setFoodRating({{ $item->id }}, {{ $i }})"
                                                                aria-label="Rate {{ $i }} star">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        </button>
                                                    @endfor
                                                </div>
                                                <div class="flex justify-between text-xs text-gray-400 px-1">
                                                    <span>{{ __('Poor') }}</span>
                                                    <span>{{ __('Excellent') }}</span>
                                                </div>
                                                <input type="hidden" name="food_ratings[{{ $item->food_id }}][rating]" id="food-rating-{{ $item->id }}" required>
                                            </div>
                                            
                                            <!-- Food Comment -->
                                            <div class="mt-3">
                                                <label for="food-comment-{{ $item->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                                    {{ __('Your review (optional)') }}
                                                </label>
                                                <textarea id="food-comment-{{ $item->id }}" 
                                                        name="food_ratings[{{ $item->food_id }}][comment]" 
                                                        rows="2" 
                                                        class="block w-full rounded-lg border-gray-200 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-2 text-sm transition-all duration-300"
                                                        placeholder="{{ __('Share your thoughts about this item...') }}"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Delivery Rating Section -->
                        <div class="pt-10">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="p-3 bg-teal-50 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">{{ __('Rate the Delivery Service') }}</h3>
                            </div>
                            
                            <!-- Delivery Rating -->
                            <div class="mb-8">
                                <label class="block text-sm font-medium text-gray-700 mb-4">
                                    {{ __('How was your delivery experience?') }}
                                </label>
                                <div class="flex items-center gap-1 mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button" 
                                                class="delivery-star w-10 h-10 cursor-pointer transition-all duration-200 transform hover:scale-110"
                                                data-rating="{{ $i }}"
                                                onclick="setDeliveryRating({{ $i }})"
                                                aria-label="Rate {{ $i }} star">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </button>
                                    @endfor
                                </div>
                                <div class="flex justify-between text-xs text-gray-400 px-1">
                                    <span>{{ __('Poor') }}</span>
                                    <span>{{ __('Excellent') }}</span>
                                </div>
                                <input type="hidden" name="courier_rating" id="delivery-rating">
                            </div>

                            <!-- Delivery Comment -->
                            <div class="mb-8">
                                <label for="delivery-comment" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('Tell us about your delivery experience (optional)') }}
                                </label>
                                <textarea id="delivery-comment" 
                                        name="courier_comment" 
                                        rows="3" 
                                        class="block w-full rounded-lg border-gray-200 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50 p-3 text-sm transition-all duration-300"
                                        placeholder="{{ __('Was the delivery timely? How was the packaging?') }}"></textarea>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-10 pt-6 border-t border-gray-100">
                            <button type="submit"
                                    class="w-full px-6 py-4 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-xl hover:from-teal-700 hover:to-cyan-700 transition-all duration-300 shadow-md hover:shadow-lg font-medium flex items-center justify-center gap-2 text-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                {{ __('Submit Your Review') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize star colors
            document.querySelectorAll('[class*="food-rating-"].star, .delivery-star').forEach(star => {
                star.querySelector('svg').classList.add('text-gray-300');
            });

            // Character counters for delivery comment
            const deliveryComment = document.getElementById('delivery-comment');
            if (deliveryComment) {
                deliveryComment.addEventListener('input', function() {
                    const count = document.getElementById('delivery-char-count');
                    if (count) count.textContent = this.value.length;
                });
            }

            // Form submission handler
            const form = document.getElementById('review-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Validate food ratings
                    const foodRatings = document.querySelectorAll('[id^="food-rating-"]');
                    let hasInvalidRating = false;
                    
                    foodRatings.forEach(ratingInput => {
                        if (!ratingInput.value) {
                            hasInvalidRating = true;
                            const itemId = ratingInput.id.split('-')[2];
                            document.querySelector(`.food-rating-${itemId}-star`).scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    });
                    
                    if (hasInvalidRating) {
                        showToast('Please rate all food items before submitting', 'error');
                        return;
                    }
                    
                    // Validate delivery rating
                    const deliveryRating = document.getElementById('delivery-rating');
                    if (!deliveryRating || !deliveryRating.value) {
                        showToast('Please rate the delivery service', 'error');
                        document.querySelector('.delivery-star').scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        return;
                    }

                    const formData = new FormData(form);
                    const submitButton = form.querySelector('button[type="submit"]');
                    const originalButtonText = submitButton.innerHTML;
                    
                    // Show loading state
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Submitting...
                    `;

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                            return;
                        }
                        
                        if (data.message) {
                            showToast(data.message, 'success');
                        }
                        
                        // Update button to show success
                        submitButton.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Review Submitted
                        `;
                        submitButton.classList.remove('from-teal-600', 'to-cyan-600', 'hover:from-teal-700', 'hover:to-cyan-700');
                        submitButton.classList.add('bg-green-500', 'hover:bg-green-600');

                        // Disable all form elements
                        form.querySelectorAll('button, textarea, input').forEach(el => {
                            el.disabled = true;
                            el.classList.add('opacity-50');
                        });
                        
                        // Redirect after a short delay
                        setTimeout(() => {
                            window.location.href = data.redirect || '{{ route("orders.history") }}';
                        }, 1500);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred while submitting your review.', 'error');
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalButtonText;
                    });
                });
            }
        });

        // Set rating for a specific food item
        function setFoodRating(itemId, rating) {
            const ratingInput = document.getElementById(`food-rating-${itemId}`);
            if (!ratingInput) return;
            
            ratingInput.value = rating;
            
            // Update star display
            for (let i = 1; i <= 5; i++) {
                const starElement = document.querySelector(`.food-rating-${itemId}-star[data-rating="${i}"]`);
                if (!starElement) continue;
                
                const svg = starElement.querySelector('svg');
                if (!svg) continue;
                
                svg.classList.remove('text-gray-300', 'text-indigo-500');
                
                if (i <= rating) {
                    svg.classList.add('text-indigo-500');
                    starElement.classList.add('scale-110');
                } else {
                    svg.classList.add('text-gray-300');
                    starElement.classList.remove('scale-110');
                }
            }
            
            // Add animation to clicked star
            const selectedStar = document.querySelector(`.food-rating-${itemId}-star[data-rating="${rating}"]`);
            if (selectedStar) {
                selectedStar.classList.add('animate-pulse');
                setTimeout(() => {
                    selectedStar.classList.remove('animate-pulse');
                }, 300);
            }
        }
        
        // Set rating for delivery
        function setDeliveryRating(rating) {
            const ratingInput = document.getElementById('delivery-rating');
            if (!ratingInput) return;
            
            ratingInput.value = rating;
            
            // Update star display
            const stars = document.querySelectorAll('.delivery-star');
            stars.forEach((star, index) => {
                const svg = star.querySelector('svg');
                if (!svg) return;
                
                svg.classList.remove('text-gray-300', 'text-teal-500');
                
                if (index < rating) {
                    svg.classList.add('text-teal-500');
                    star.classList.add('scale-110');
                } else {
                    svg.classList.add('text-gray-300');
                    star.classList.remove('scale-110');
                }
            });
            
            // Add animation to clicked star
            if (stars[rating - 1]) {
                stars[rating - 1].classList.add('animate-pulse');
                setTimeout(() => {
                    stars[rating - 1].classList.remove('animate-pulse');
                }, 300);
            }
        }

        function showToast(message, type) {
            // Remove any existing toasts
            document.querySelectorAll('.toast-message').forEach(el => el.remove());
            
            const toast = document.createElement('div');
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };
            
            toast.className = `toast-message fixed bottom-5 right-5 px-6 py-3 rounded-lg text-white shadow-lg ${colors[type] || 'bg-gray-800'} animate-fade-in-up flex items-center gap-2`;
            
            // Add icon based on type
            let icon = '';
            switch(type) {
                case 'success':
                    icon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>`;
                    break;
                case 'error':
                    icon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>`;
                    break;
                default:
                    icon = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>`;
            }
            
            toast.innerHTML = `${icon} <span>${message}</span>`;
            document.body.appendChild(toast);
            
            // Auto-remove after delay
            setTimeout(() => {
                toast.classList.add('animate-fade-out');
                setTimeout(() => {
                    if (toast.parentNode) {
                        document.body.removeChild(toast);
                    }
                }, 500);
            }, 5000);
        }
    </script>
    @endpush

    @push('styles')
    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        
        .animate-fade-out {
            animation: fadeOut 0.5s ease-in forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
        
        .animate-pulse {
            animation: pulse 0.3s ease-in-out;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
    @endpush
</x-app-layout>