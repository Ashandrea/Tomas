<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Rate Your Order</h1>

        <h2 class="text-xl font-semibold mb-4">Rate the Seller</h2>
        <form id="seller-form" action="{{ route('orders.submitRating', ['order' => $orderId, 'type' => 'seller']) }}" method="POST" class="mb-8">
            @csrf
            <div class="mb-4">
                <label for="seller-rating" class="block text-sm font-medium text-gray-700">Rating</label>
                <div id="seller-star-rating" class="flex space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" class="star" data-value="{{ $i }}">
                            <svg class="w-6 h-6 text-gray-400 hover:text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37-2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.01 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z" />
                            </svg>
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="seller-rating" required>
                <div id="seller-form-rating-display" class="mt-2 text-sm text-gray-600"></div>
            </div>
            <div class="mb-4">
                <label for="seller-comment" class="block text-sm font-medium text-gray-700">Comment</label>
                <textarea name="comment" id="seller-comment" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Submit Rating</button>
        </form>

        <h2 class="text-xl font-semibold mb-4">Rate the Courier</h2>
        <form id="courier-form" action="{{ route('orders.submitRating', ['order' => $orderId, 'type' => 'courier']) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="courier-rating" class="block text-sm font-medium text-gray-700">Rating</label>
                <div id="courier-star-rating" class="flex space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <button type="button" class="star" data-value="{{ $i }}">
                            <svg class="w-6 h-6 text-gray-400 hover:text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37-2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.01 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z" />
                            </svg>
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="courier-rating" required>
                <div id="courier-form-rating-display" class="mt-2 text-sm text-gray-600"></div>
            </div>
            <div class="mb-4">
                <label for="courier-comment" class="block text-sm font-medium text-gray-700">Comment</label>
                <textarea name="comment" id="courier-comment" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Submit Rating</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function setupStarRating(containerId, inputId) {
                const stars = document.querySelectorAll(`#${containerId} .star`);
                const ratingInput = document.getElementById(inputId);

                stars.forEach(star => {
                    star.addEventListener('click', function () {
                        const value = this.getAttribute('data-value');
                        ratingInput.value = value;

                        stars.forEach(s => {
                            s.querySelector('svg').classList.remove('text-yellow-500');
                            s.querySelector('svg').classList.add('text-gray-400');
                        });

                        for (let i = 0; i < value; i++) {
                            stars[i].querySelector('svg').classList.remove('text-gray-400');
                            stars[i].querySelector('svg').classList.add('text-yellow-500');
                        }
                    });
                });
            }

            setupStarRating('seller-star-rating', 'seller-rating');
            setupStarRating('courier-star-rating', 'courier-rating');

            // Enhance AJAX functionality
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const formData = new FormData(this);
                    const url = this.action;

                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            alert('Rating submitted successfully!');

                            // Update star rating to number
                            const ratingValue = formData.get('rating');
                            const ratingDisplay = document.querySelector(`#${form.id}-rating-display`);
                            if (ratingDisplay) {
                                ratingDisplay.textContent = ratingValue;
                            }

                            // Dynamically update the "Available Food Items" section
                            const foodsContainer = document.querySelector('.grid');
                            if (foodsContainer) {
                                fetch('/refresh-foods')
                                    .then(response => response.text())
                                    .then(html => {
                                        foodsContainer.innerHTML = html;
                                    });
                            }
                        } else {
                            alert('Failed to submit rating. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting the rating.');
                    });
                });
            });
        });
    </script>
</x-app-layout>