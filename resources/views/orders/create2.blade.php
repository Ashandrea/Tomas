<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900">
            {{ __('Create New Order') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Error Display -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-red-500 mr-3">
  <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>

                        <h3 class="text-red-800 font-medium">Please fix the following errors:</h3>
                    </div>
                    <ul class="mt-2 ml-8 list-disc text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Food Items Section -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Item</h3>
                        
                        @foreach($foods as $sellerId => $sellerFoods)
                            <div class="mb-8 last:mb-0">
                                <div class="flex items-center mb-4">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center overflow-hidden mr-3">
                                        @if($sellerFoods->first()->seller->profile_photo)
                                            <img src="{{ Storage::url($sellerFoods->first()->seller->profile_photo) }}" alt="{{ $sellerFoods->first()->seller->name }}" class="h-full w-full object-cover">
                                        @else
                                            <span class="text-indigo-600 font-medium">{{ substr($sellerFoods->first()->seller->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <h4 class="font-medium text-gray-900 hover:text-indigo-600 transition-colors duration-200">
                                        <a href="{{ route('profile.show', $sellerFoods->first()->seller) }}" class="hover:underline">
                                            {{ $sellerFoods->first()->seller->name }}
                                        </a>
                                    </h4>
                                </div>
                                
                                <div class="space-y-3">
                                    @foreach($sellerFoods as $food)
                                        <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:border-indigo-100 transition-colors duration-200">
                                            <div class="flex items-center space-x-4">
                                                <x-food-image :food="$food" class="h-16 w-16 rounded-lg object-cover" />
                                                <div>
                                                    <h5 class="font-medium text-gray-900">{{ $food->name }}</h5>
                                                    <p class="text-sm text-gray-500 line-clamp-1">{{ $food->description }}</p>
                                                    <p class="text-sm font-medium text-indigo-600">Rp {{ number_format($food->price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center space-x-2">
                                                <button type="button" 
                                                        onclick="decrementQuantity('{{ $food->id }}')"
                                                        class="p-1.5 rounded-full text-gray-400 hover:bg-gray-50 hover:text-gray-600 transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                                    </svg>

                                                </button>
                                                
                                                <input type="number" 
                                                       name="items[{{ $food->id }}][quantity]" 
                                                       id="quantity-{{ $food->id }}" 
                                                       value="{{ $cartItems[$food->id] ?? 0 }}" 
                                                       min="0" 
                                                       class="w-12 text-center border-gray-200 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                                <input type="hidden" name="items[{{ $food->id }}][food_id]" value="{{ $food->id }}">
                                                
                                                <button type="button" 
                                                        onclick="incrementQuantity('{{ $food->id }}')"
                                                        class="p-1.5 rounded-full text-gray-400 hover:bg-gray-50 hover:text-gray-600 transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                                    </svg>

                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary Section -->
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Ringkasan Pesanan</h3>
                        
                        <!-- Delivery Location -->
                        <div class="mb-6">
                            <label for="delivery_location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi Pengiriman</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>

                                    
                                    
                                </div>
                                <input type="text" 
                                       name="delivery_location" 
                                       id="delivery_location" 
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                       placeholder="Masukkan alamat pengiriman" 
                                       required>
                            </div>
                        </div>
                        
                        <!-- Catatan Khusus -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Khusus</label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <textarea name="notes" 
                                          id="notes" 
                                          rows="3" 
                                          class="block w-full rounded-md border-gray-300 pl-3 pr-10 py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                          placeholder="Contoh: Tingkat pedas 2, tanpa acar, dll."></textarea>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Opsional: Tambahkan instruksi khusus untuk penjual</p>
                        </div>
                        
                        <!-- Order Total -->
                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-900 font-medium" id="subtotal-amount">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Biaya Pengiriman</span>
                                <span class="text-gray-900 font-medium" id="delivery-fee">Rp 5,000</span>
                            </div>
                            <div class="flex justify-between items-center text-lg font-bold text-gray-900 mt-4 pt-4 border-t border-gray-200">
                                <span>Total</span>
                                <span id="total-amount">Rp 0</span>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                form="orderForm"
                                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            Pesan Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form (positioned outside for proper submission) -->
    <form action="{{ route('orders.store') }}" method="POST" id="orderForm" class="hidden">
        @csrf
        <input type="hidden" name="from_create2" value="1">
        @foreach($foods as $sellerId => $sellerFoods)
            <input type="hidden" name="seller_id" value="{{ $sellerId }}">
            @foreach($sellerFoods as $food)
                <input type="hidden" name="items[{{ $food->id }}][food_id]" value="{{ $food->id }}">
                <input type="hidden" name="items[{{ $food->id }}][quantity]" id="form-quantity-{{ $food->id }}" value="0">
            @endforeach
        @endforeach
        <input type="hidden" name="delivery_location" id="form-delivery-location">
        <input type="hidden" name="notes" id="form-notes">
        <input type="hidden" name="delivery_fee" id="form-delivery-fee" value="0">
    </form>

    <script>
        // Food data with prices and menu type
        const foods = {};
        @foreach($foods as $sellerId => $sellerFoods)
            @foreach($sellerFoods as $food)
                foods['{{ $food->id }}'] = {
                    price: {{ $food->price }},
                    isOtherMenu: {{ $food->show_in_other_menu ? 'true' : 'false' }}
                };
            @endforeach
        @endforeach

        // Format price to Indonesian Rupiah
        const formatPrice = (amount) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(amount).replace('IDR', 'Rp');
        }

        // Calculate and update order totals
        const updateOrderTotals = () => {
            console.log('updateOrderTotals called');
            let subtotal = 0;
            
            // Calculate subtotal from all items
            Object.entries(foods).forEach(([id, food]) => {
                const input = document.getElementById(`quantity-${id}`);
                if (!input) {
                    console.error(`Input with id quantity-${id} not found`);
                    return;
                }
                const quantity = parseInt(input.value) || 0;
                console.log(`Food ${id}: quantity=${quantity}, price=${food.price}`);
                subtotal += food.price * quantity;
            });
            
            console.log('Subtotal:', subtotal);
            
            // Check if all items are from 'Menu Lainnya'
            let allItemsFromOtherMenu = true;
            Object.entries(foods).forEach(([id, food]) => {
                const input = document.getElementById(`quantity-${id}`);
                if (!input) return;
                const quantity = parseInt(input.value) || 0;
                if (quantity > 0 && !food.isOtherMenu) {
                    allItemsFromOtherMenu = false;
                }
            });
            
            // Set delivery fee to 0 if all items are from 'Menu Lainnya', otherwise 5000
            const deliveryFee = allItemsFromOtherMenu ? 0 : 5000;
            const total = subtotal + deliveryFee;
            
            console.log('Delivery fee:', deliveryFee);
            console.log('Total:', total);
            
            // Get DOM elements
            const subtotalEl = document.getElementById('subtotal-amount');
            const deliveryFeeEl = document.getElementById('delivery-fee');
            const totalEl = document.getElementById('total-amount');
            
            console.log('DOM elements:', { subtotalEl, deliveryFeeEl, totalEl });
            
            // Update DOM if elements exist
            if (subtotalEl) subtotalEl.textContent = formatPrice(subtotal);
            if (deliveryFeeEl) deliveryFeeEl.textContent = formatPrice(deliveryFee);
            if (totalEl) totalEl.textContent = formatPrice(total);
            
            // Update the delivery fee in the form
            const deliveryFeeInput = document.getElementById('form-delivery-fee');
            if (deliveryFeeInput) {
                deliveryFeeInput.value = deliveryFee;
            }
            
            console.log('DOM updated with values:', {
                subtotal: formatPrice(subtotal),
                deliveryFee: formatPrice(deliveryFee),
                total: formatPrice(total)
            });
        }

        // Quantity adjustment functions
        const incrementQuantity = (id) => {
            const input = document.getElementById(`quantity-${id}`);
            input.value = (parseInt(input.value) || 0) + 1;
            updateOrderTotals();
        }

        const decrementQuantity = (id) => {
            const input = document.getElementById(`quantity-${id}`);
            const value = parseInt(input.value) || 0;
            if (value > 0) {
                input.value = value - 1;
                updateOrderTotals();
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM loaded, initializing...');
            console.log('Foods data:', foods);
            
            // Add input event listeners to all quantity fields
            Object.keys(foods).forEach(id => {
                const input = document.getElementById(`quantity-${id}`);
                console.log(`Input for food ${id}:`, input);
                if (input) {
                    input.addEventListener('change', updateOrderTotals);
                }
            });

            // Initialize totals
            console.log('Calling updateOrderTotals()');
            updateOrderTotals();

            // Enhanced form validation and data preparation
            document.getElementById('orderForm').addEventListener('submit', function(e) {
                let hasItems = false;
                const deliveryLocation = document.getElementById('delivery_location').value.trim();
                
                // Update hidden form fields with current values
                document.getElementById('form-delivery-location').value = deliveryLocation;
                document.getElementById('form-notes').value = document.getElementById('notes').value;
                
                // Check for selected items and update form data
                Object.keys(foods).forEach(id => {
                    const quantityInput = document.getElementById(`quantity-${id}`);
                    const formQuantityInput = document.getElementById(`form-quantity-${id}`);
                    const quantity = parseInt(quantityInput.value) || 0;
                    
                    // Update the hidden form field
                    if (formQuantityInput) {
                        formQuantityInput.value = quantity;
                    }
                    
                    if (quantity > 0) {
                        hasItems = true;
                    }
                });

                // Validation
                if (!hasItems) {
                    e.preventDefault();
                    showToast('Please select at least one item', 'error');
                    return;
                }


                if (!deliveryLocation) {
                    e.preventDefault();
                    showToast('Please enter a delivery address', 'error');
                    document.getElementById('delivery_location').focus();
                }
            });
        });

        // Toast notification function
        const showToast = (message, type = 'success') => {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-md shadow-md text-white ${
                type === 'error' ? 'bg-red-500' : 'bg-green-500'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
</x-app-layout>