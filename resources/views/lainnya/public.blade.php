<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Lainnya') }}
            </h2>
            @auth
                @if(auth()->user()->role === 'seller')
                    <a href="{{ route('foods.create') }}" class="inline-flex items-center px-4 py-2 bg-[#547792] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#47687d] focus:bg-[#47687d] active:bg-[#3a5a70] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Tambah Makanan Baru') }}
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <!-- Search Bar -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">{{ __('Daftar Lainnya') }}</h3>
                        <div class="relative">
                            <input type="text" 
                                   id="search"
                                   name="search"
                                   placeholder="{{ __('Cari...') }}"
                                   class="w-64 pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#547792] focus:border-transparent"
                                   autocomplete="off">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    @if($foods->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-6">
                            @foreach($foods as $food)
                                <div class="group relative bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 food-card">
                                    <x-food-image :food="$food" class="h-48 rounded-t-xl group-hover:scale-105 transition-all duration-300" />

                                    <div class="p-4">
                                        <h4 class="text-lg font-semibold text-gray-800 truncate mb-2">{{ $food->name }}</h4>
                                        <p class="text-sm text-gray-500 mb-2">{{ __('Dari ') }}<span class="font-medium">{{ $food->seller->name }}</span></p>
                                        <div class="flex items-center justify-between mb-4">
                                            <p class="text-xl font-bold text-[#547792]">Rp {{ number_format($food->price, 0, ',', '.') }}</p>
                                            <div class="flex items-center bg-pink-100 px-2 py-1 rounded-full">
                                                <svg class="w-4 h-4 text-red-800" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37-2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.01 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z"/>
                                                </svg>
                                                <span class="text-sm font-semibold text-red-800 ml-1">{{ number_format($food->average_rating ?? 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('orders.create2', ['food' => $food->id]) }}"
                                           class="block w-full text-center px-4 py-2.5 bg-[#547792] text-white rounded-lg hover:bg-[#47687d] transition-all font-medium flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            {{ __('Pesan') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- No results message (hidden by default) -->
                        <div class="no-results text-center py-16 hidden">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">{{ __('Tidak Ditemukan') }}</h3>
                            <p class="mt-1 text-gray-500">{{ __('Tidak ada menu yang cocok dengan pencarian Anda.') }}</p>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $foods->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">{{ __('Belum Ada Menu Tersedia') }}</h3>
                            <p class="mt-1 text-gray-500">{{ __('Tidak ada menu yang ditampilkan di halaman ini.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Notification Components -->
    <div id="notification" class="hidden fixed top-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-lg z-50">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">Notification message</p>
        </div>
    </div>

    <!-- Cart Box -->
    <div id="cartBox" class="fixed bottom-4 right-4 bg-[#547792] text-white rounded-lg shadow-lg z-50 hover:bg-[#47687d] transition-all duration-300">
        <div class="p-4">
            <div class="flex items-center justify-between cursor-pointer" onclick="toggleCartDetails()">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-lg font-medium">Keranjang</span>
                    <span id="cartItemCount" class="ml-2 bg-red-500 text-white rounded-full px-2 py-0.5 text-xs">0</span>
                </div>
                <span id="cartTotal" class="ml-4 font-semibold">Rp 0</span>
            </div>

            <!-- Cart Details Panel -->
            <div id="cartDetails" class="hidden mt-4 border-t border-white/20 pt-4">
                <div id="cartItems" class="max-h-60 overflow-y-auto space-y-2">
                    <!-- Cart items will be inserted here -->
                </div>

                <div class="mt-4 pt-4 border-t border-white/20">
                    <a href="{{ route('orders.create') }}" id="checkoutButton"
                       class="w-full bg-white text-[#547792] rounded px-4 py-2 text-center font-medium hover:bg-gray-100 transition-colors hidden">
                        Pesan
                    </a>
                    <button onclick="clearCart()"
                            class="w-full mt-2 border border-white/50 rounded px-4 py-2 text-center font-medium hover:bg-[#47687d] transition-colors">
                        Kosongkan Keranjang
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            let searchTimeout;
            
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                
                searchTimeout = setTimeout(() => {
                    const searchTerm = this.value.trim().toLowerCase();
                    const foodCards = document.querySelectorAll('.food-card');
                    let hasResults = false;
                    
                    foodCards.forEach(card => {
                        const foodName = card.querySelector('h4').textContent.toLowerCase();
                        const match = foodName.includes(searchTerm);
                        
                        if (match) {
                            card.style.display = 'block';
                            hasResults = true;
                        } else {
                            card.style.display = 'none';
                        }
                    });
                    
                    // Show/hide no results message
                    const noResults = document.querySelector('.no-results');
                    if (noResults) {
                        noResults.style.display = hasResults || searchTerm === '' ? 'none' : 'block';
                    }
                }, 300);
            });

            // Initialize cart from localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            updateCartUI();

            // Add to cart function
            window.addToCart = function(event, id, name, price) {
                event.preventDefault();
                
                // Find if item already exists in cart
                const existingItem = cart.find(item => item.id === id);
                
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: id,
                        name: name,
                        price: price,
                        quantity: 1
                    });
                }
                
                // Save to localStorage
                localStorage.setItem('cart', JSON.stringify(cart));
                
                // Update UI
                updateCartUI();
                
                // Show notification
                showNotification('Item berhasil ditambahkan ke keranjang');
            };

            function updateCartUI() {
                const cartItemCount = document.getElementById('cartItemCount');
                const cartTotal = document.getElementById('cartTotal');
                const cartItems = document.getElementById('cartItems');
                const checkoutButton = document.getElementById('checkoutButton');
                
                // Update cart count
                const itemCount = cart.reduce((total, item) => total + item.quantity, 0);
                cartItemCount.textContent = itemCount;
                
                // Update total
                const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                cartTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
                
                // Update cart items
                if (cartItems) {
                    cartItems.innerHTML = '';
                    
                    if (cart.length === 0) {
                        cartItems.innerHTML = '<p class="text-sm text-white text-center py-4">Keranjang kosong</p>';
                        checkoutButton.classList.add('hidden');
                    } else {
                        cart.forEach(item => {
                            const itemElement = document.createElement('div');
                            itemElement.className = 'flex justify-between items-center p-2 bg-white rounded-lg';
                            itemElement.innerHTML = `
                                <div class="flex-1">
                                    <p class="text-sm font-medium">${item.name}</p>
                                    <p class="text-xs text-gray-500">${item.quantity} x Rp ${item.price.toLocaleString('id-ID')}</p>
                                </div>
                                <button onclick="removeFromCart('${item.id}')" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            `;
                            cartItems.appendChild(itemElement);
                        });
                        
                        checkoutButton.classList.remove('hidden');
                    }
                }
            }

            // Remove item from cart
            window.removeFromCart = function(id) {
                cart = cart.filter(item => item.id !== id);
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
                showNotification('Item dihapus dari keranjang');
            };

            // Clear cart
            window.clearCart = function() {
                if (confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
                    cart = [];
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartUI();
                    document.getElementById('cartDetails').classList.add('hidden');
                    showNotification('Keranjang telah dikosongkan');
                }
            };

            // Toggle cart details
            window.toggleCartDetails = function() {
                const cartDetails = document.getElementById('cartDetails');
                cartDetails.classList.toggle('hidden');
            };

            // Show notification
            function showNotification(message) {
                const notification = document.getElementById('notification');
                const notificationMessage = notification.querySelector('p');
                
                notificationMessage.textContent = message;
                notification.classList.remove('hidden');
                
                setTimeout(() => {
                    notification.classList.add('hidden');
                }, 3000);
            }
        });
    </script>
    @endpush
</x-app-layout>
