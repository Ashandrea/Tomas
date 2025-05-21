<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Beranda') }}
            </h2>
            <div class="text-sm font-medium text-gray-500">
                {{ ucfirst(Auth::user()->role) }}
            </div>
        </div>
    </x-slot>

    <!-- Add SweetAlert2 CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui@5/material-ui.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-hero />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Available Food Items -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">{{ __('Daftar Makanan Tersedia') }}</h3>
                        <div class="relative">
                            <input type="text"
                                   id="search"
                                   name="search"
                                   placeholder="{{ __('Cari makanan atau penjual...') }}"
                                   value="{{ request('search') }}"
                                   class="w-64 rounded-lg border-gray-300 focus:border-[#547792] focus:ring focus:ring-[#547792] focus:ring-opacity-50">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div id="foods-container">
                        @include('dashboard.partials.food-list')
                    </div>
                </div>
            </div>

            <!-- Notification Components -->
            <div id="notification" class="hidden fixed top-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-lg z-50">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="font-medium">Item berhasil ditambahkan ke keranjang</p>
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

            <script>
                let typingTimer;
                const doneTypingInterval = 500;
                const searchInput = document.getElementById('search');

                searchInput.addEventListener('input', function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(performSearch, doneTypingInterval);
                });

                function performSearch() {
                    const searchTerm = searchInput.value;
                    const container = document.getElementById('foods-container');

                    fetch(`{{ url()->current() }}?search=${encodeURIComponent(searchTerm)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        container.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            </script>

            <script>
                let notificationTimeout;
                let cartBoxTimeout;

                // Initialize cart from localStorage
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                function updateCartUI() {
                    const cartItemCount = document.getElementById('cartItemCount');
                    const cartTotal = document.getElementById('cartTotal');
                    const cartItems = document.getElementById('cartItems');
                    const checkoutButton = document.getElementById('checkoutButton');

                    // Update count and total
                    cartItemCount.textContent = cart.length;
                    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                    cartTotal.textContent = `Rp ${formatPrice(total)}`;

                    // Update items list
                    cartItems.innerHTML = cart.map(item => `
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex-1">
                                <p class="font-medium">${item.name}</p>
                                <p class="text-white/80">Rp ${formatPrice(item.price)} × ${item.quantity}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="updateQuantity('${item.id}', ${item.quantity - 1})"
                                        class="w-6 h-6 flex items-center justify-center rounded bg-white/20 hover:bg-white/30">
                                    -
                                </button>
                                <span>${item.quantity}</span>
                                <button onclick="updateQuantity('${item.id}', ${item.quantity + 1})"
                                        class="w-6 h-6 flex items-center justify-center rounded bg-white/20 hover:bg-white/30">
                                    +
                                </button>
                            </div>
                        </div>
                    `).join('');

                    // Show/hide checkout button
                    checkoutButton.classList.toggle('hidden', cart.length === 0);

                    // Update checkout button href with cart items
                    if (cart.length > 0) {
                        const cartData = cart.map(item => `${item.id}:${item.quantity}`).join(',');
                        checkoutButton.href = `{{ route('orders.create') }}?cart=${encodeURIComponent(cartData)}`;
                    }

                    // Save to localStorage
                    localStorage.setItem('cart', JSON.stringify(cart));
                }

                function formatPrice(price) {
                    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }

                function addToCart(event, id, name, price) {
                    // Convert price to number if it's a string
                    price = typeof price === 'string' ? parseFloat(price) : price;

                    // Find if item already exists in cart
                    const existingItem = cart.find(item => item.id === id);

                    if (existingItem) {
                        existingItem.quantity += 1;
                    } else {
                        cart.push({ id, name, price, quantity: 1 });
                    }

                    updateCartUI();
                    showNotification();
                    showCartBox();

                    // Get the clicked button and cart box for animation
                    const button = event.currentTarget;
                    const cartBox = document.getElementById('cartBox');

                    // Create and animate clone
                    const clone = button.cloneNode(true);
                    const rect = button.getBoundingClientRect();
                    const cartRect = cartBox.getBoundingClientRect();

                    clone.style.width = rect.width + 'px';
                    clone.style.height = rect.height + 'px';
                    clone.style.position = 'fixed';
                    clone.style.top = rect.top + 'px';
                    clone.style.left = rect.left + 'px';
                    clone.style.zIndex = '100';
                    clone.style.pointerEvents = 'none';
                    clone.style.transition = 'all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1.2)';
                    clone.style.transform = 'scale(1)';

                    document.body.appendChild(clone);

                    requestAnimationFrame(() => {
                        clone.style.transform = 'scale(0.1)';
                        clone.style.top = (cartRect.top + cartRect.height/2) + 'px';
                        clone.style.left = (cartRect.left + cartRect.width/2) + 'px';
                        clone.style.opacity = '0';
                    });

                    setTimeout(() => {
                        clone.remove();
                    }, 600);
                }

                function updateQuantity(id, newQuantity) {
                    if (newQuantity <= 0) {
                        cart = cart.filter(item => item.id !== id);
                    } else {
                        const item = cart.find(item => item.id === id);
                        if (item) {
                            item.quantity = newQuantity;
                        }
                    }
                    updateCartUI();
                }

                function clearCart() {
                    cart = [];
                    updateCartUI();
                    hideCartDetails();
                }

                // Function to handle single item order
                function orderSingleItem(event, id, name, price) {
                    // Create a temporary cart with only the clicked item
                    const tempCart = [{ id, name, price, quantity: 1 }];
                    const cartData = tempCart.map(item => `${item.id}:${item.quantity}`).join(',');
                    // Redirect to checkout with only this item
                    window.location.href = `{{ route('orders.create') }}?cart=${encodeURIComponent(cartData)}`;
                }

                function showNotification() {
                    const notification = document.getElementById('notification');
                    notification.classList.remove('hidden');
                    notification.classList.add('animate-fade-in-down');

                    clearTimeout(notificationTimeout);
                    notificationTimeout = setTimeout(() => {
                        notification.classList.add('hidden');
                        notification.classList.remove('animate-fade-in-down');
                    }, 2000);
                }

                function showCartBox() {
                    const cartBox = document.getElementById('cartBox');
                    cartBox.classList.remove('hidden');
                    clearTimeout(cartBoxTimeout);
                }

                function toggleCartDetails() {
                    const cartDetails = document.getElementById('cartDetails');
                    cartDetails.classList.toggle('hidden');
                }

                function hideCartDetails() {
                    const cartDetails = document.getElementById('cartDetails');
                    cartDetails.classList.add('hidden');
                }np

                // Initialize cart UI on page load
                updateCartUI();
            </script>

            <!-- Modern Menu Section with Auto-Scrolling Gallery -->
<div class="mt-16 text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-4">
        <h3 class="text-3xl font-bold text-gray-900 mb-4">Temukan Lebih Banyak Menu</h3>
        <p class="text-gray-600 mb-8 text-lg max-w-2xl mx-auto leading-relaxed">
            Jelajahi berbagai pilihan menu lainnya yang tersedia di Toko Mahasiswa.
            Dukung mahasiswa dalam mengembangkan keterampilan bisnis mereka.
        </p>
        <a href="{{ route('menu.public') }}"
           class="inline-flex items-center px-8 py-3.5 mb-12 text-lg font-medium rounded-lg text-white bg-[#547792] hover:bg-[#47687d] transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
            Lihat Menu lainnya
            <svg class="ml-3 w-5 h-5 transition-transform duration-300 group-hover:translate-x-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </a>
    </div>

    <!-- Auto-scrolling image gallery -->
    <div class="relative w-full h-40 overflow-hidden">
        <div class="absolute inset-0 flex items-center space-x-8 animate-scroll-infinite">
            <!-- Duplicate images for seamless looping -->
            <img src="{{ asset('img/Pakaian.jpg') }}" alt="Menu 1" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/buah1.jpg') }}" alt="Menu 2" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Hot dog.jpg') }}" alt="Menu 3" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Hp.jpg') }}" alt="Menu 4" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Sepatu.jpg') }}" alt="Menu 5" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Tas.jpg') }}" alt="Menu 6" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Strawberry.jpg') }}" alt="Menu 7" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Buku.jpg') }}" alt="Menu 8" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Alat tulis.jpg') }}" alt="Menu 9" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Sosis.jpg') }}" alt="Menu 10" class="h-32 w-32 object-cover rounded-lg shadow-md">

            <!-- Mirrored images for seamless looping -->
            <img src="{{ asset('img/Pakaian.jpg') }}" alt="Menu 1" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/buah1.jpg') }}" alt="Menu 2" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Hot dog.jpg') }}" alt="Menu 3" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Hp.jpg') }}" alt="Menu 4" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Sepatu.jpg') }}" alt="Menu 5" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Tas.jpg') }}" alt="Menu 6" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Strawberry.jpg') }}" alt="Menu 7" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Buku.jpg') }}" alt="Menu 8" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Alat tulis.jpg') }}" alt="Menu 9" class="h-32 w-32 object-cover rounded-lg shadow-md">
            <img src="{{ asset('img/Sosis.jpg') }}" alt="Menu 10" class="h-32 w-32 object-cover rounded-lg shadow-md">
        </div>
    </div>
</div>

<style>
    @keyframes scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    .animate-scroll-infinite {
        animation: scroll 30s linear infinite;
        display: flex;
        width: max-content;
    }

    .animate-scroll-infinite:hover {
        animation-play-state: paused;
    }
</style>

            <style>
                @keyframes fadeInDown {
                    from {
                        opacity: 0;
                        transform: translateY(-10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .animate-fade-in-down {
                    animation: fadeInDown 0.3s ease-out;
                }

                .button-clone {
                    position: fixed;
                    z-index: 100;
                    pointer-events: none;
                    transition: all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1.2);
                }
            </style>

            <style>
                @keyframes gradient {
                    0% { background-position: 0% 50%; }
                    50% { background-position: 100% 50%; }
                    100% { background-position: 0% 50%; }
                }
                .animate-gradient {
                    animation: gradient 6s ease infinite;
                }
            </style>

            <script>
                function handleSellerLogin() {
                    // First logout the current user
                    fetch("{{ route('logout') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            // After successful logout, redirect to seller login
                            window.location.href = "{{ route('seller.login') }}";
                        } else {
                            throw new Error('Logout failed');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal logout. Silakan coba lagi.');
                    });
                }
            </script>
        </div>
    </div>
</x-app-layout>