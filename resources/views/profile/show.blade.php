@use('Illuminate\Support\Str')

<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-2xl text-gray-900">
                    {{ __('Profil Pengguna') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <!-- Profile Header -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 transition-all duration-300 hover:shadow-2xl">
                <!-- Cover Photo -->
                <div class="h-48 relative bg-gray-200 overflow-hidden">
                    @if($user->cover_photo)
                        <img src="{{ $user->cover_photo_url }}" alt="Cover Photo" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-r from-blue-500 to-indigo-600"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                </div>
                
                <!-- Profile Info -->
                <div class="px-8 pb-8 -mt-16 relative">
                    <div class="flex flex-col items-center md:flex-row md:items-end md:justify-between">
                        <!-- Profile Photo -->
                        <div class="relative group">
                            <div class="h-32 w-32 rounded-full border-4 border-white bg-white shadow-xl overflow-hidden">
                                @if($user->profile_photo)
                                    <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center text-5xl font-bold text-indigo-600">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            @if(auth()->id() === $user->id)
                                <div class="absolute inset-0 bg-black/30 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-300">
                                    <a href="{{ route('profile.edit') }}" class="text-white bg-black/50 p-2 rounded-full hover:bg-black/70 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        @if(auth()->id() === $user->id)
                            <div class="mt-4 md:mt-0">
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-medium text-sm leading-tight rounded-full shadow-md hover:from-indigo-700 hover:to-blue-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Profil
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <!-- User Details -->
                    <div class="mt-6 text-center md:text-left">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-lg text-gray-600 mt-1">{{ $user->email }}</p>
                        
                        <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-4">
                            @if($user->phone)
                                <div class="flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $user->phone }}
                                </div>
                            @endif
                            
                            @if($user->nim)
                                <div class="flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    NIM: {{ $user->nim }}
                                </div>
                            @endif
                            
                            <div class="flex items-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ ucfirst($user->role) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User's Menu Section -->
            @if($user->foods && $user->foods->count() > 0)
                <div class="mb-12">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Menu yang Dijual</h2>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-medium rounded-full">
                            {{ $user->foods->count() }} {{ Str::plural('Menu', $user->foods->count()) }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($user->foods as $food)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                                <!-- Food Image -->
                                <div class="relative h-48 bg-gray-100 overflow-hidden">
                                    @if($food->image)
                                        <img src="{{ Storage::url($food->image) }}" alt="{{ $food->name }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                            <span class="text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </span>
                                        </div>
                                    @endif
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                                        <span class="text-white font-semibold text-lg">{{ $food->name }}</span>
                                        <div class="text-white/90 mt-1">Rp {{ number_format($food->price, 0, ',', '.') }}</div>
                                    </div>
                                    @if($food->category)
                                        <div class="absolute top-3 right-3">
                                            <span class="bg-white/90 text-indigo-600 text-xs font-semibold px-2.5 py-1 rounded-full">
                                                {{ $food->category->name }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Food Details -->
                                <div class="p-5">
                                    <p class="text-gray-600 line-clamp-2 mb-4">
                                        {{ $food->description }}
                                    </p>
                                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
                                        <span class="text-gray-500 text-sm">
                                            <i class="fas fa-shopping-cart mr-1"></i> {{ $food->orders_count }}x terjual
                                        </span>
                                        <div class="flex items-center space-x-4">
                                            <button onclick="toggleLike(event, '{{ $food->id }}')" class="flex items-center space-x-1 text-sm focus:outline-none">
                                                <i id="like-icon-{{ $food->id }}" class="fas fa-heart {{ in_array($food->id, $likedFoodIds) ? 'text-red-500' : 'text-gray-400' }} hover:text-red-500 transition-colors"></i>
                                                @if(($food->likes_count ?? 0) > 0)
                                                    <span id="like-count-{{ $food->id }}" class="text-gray-600">{{ $food->likes_count }}</span>
                                                @endif
                                            </button>
                                            @if(auth()->id() !== $user->id || auth()->user()->role !== 'seller')
                                                <a href="{{ route('orders.create', $food) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                                    Pesan
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif(auth()->check() && $user->role === 'seller')
                <!-- Empty State - Only show for seller profiles -->
                @if(auth()->id() === $user->id)
                    <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <div class="h-24 w-24 mx-auto mb-6 text-indigo-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Menu</h3>
                            <p class="text-gray-500 mb-6">Anda belum menambahkan menu makanan.</p>
                            <a href="{{ route('foods.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Menu Pertama
                            </a>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-2xl shadow-md p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Menu</h3>
                            <p class="text-gray-500">Penjual ini belum menambahkan menu makanan.</p>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
    @push('scripts')
    <script>
        function toggleLike(event, foodId) {
            event.preventDefault();
            
            // Check if user is authenticated
            @auth
                const likeButton = event.currentTarget;
                const likeIcon = document.getElementById(`like-icon-${foodId}`);
                const likeCount = document.getElementById(`like-count-${foodId}`);
                
                // Show loading state
                likeIcon.classList.add('fa-spin');
                
                // Send AJAX request
                fetch(`/foods/${foodId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update like icon
                        if (data.is_liked) {
                            likeIcon.classList.remove('text-gray-400');
                            likeIcon.classList.add('text-red-500');
                        } else {
                            likeIcon.classList.remove('text-red-500');
                            likeIcon.classList.add('text-gray-400');
                        }
                        
                        // Update like count
                        likeCount.textContent = data.likes_count;
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    // Remove loading state
                    likeIcon.classList.remove('fa-spin');
                });
            @else
                // Redirect to login if not authenticated
                window.location.href = '{{ route('login') }}';
            @endauth
        }
    </script>
    @endpush
</x-app-layout>
