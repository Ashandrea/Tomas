<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Menu Makanan Baru (Mahasiswa)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ url('/foods/store2') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nama Makanan') }}</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan nama makanan" class="py-2 px-3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Deskripsi') }}</label>
                            <div class="mt-1">
                                <textarea name="description" id="description" rows="3" placeholder="Masukkan deskripsi makanan" class="py-2 px-3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="mb-6">
                            <label for="price" class="block text-sm font-medium text-gray-700">{{ __('Harga') }}</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="Masukkan harga" class="py-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gambar -->
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700">{{ __('Gambar') }}</label>
                            <div class="mt-1">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1">
                                        <input type="file" name="image" id="image" onchange="previewImage(this)" accept="image/*" class="py-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <!-- Pratinjau Gambar -->
                                <div id="imagePreview" class="mt-4 hidden">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Pratinjau:</p>
                                    <img id="preview" src="#" alt="Pratinjau" class="h-40 w-40 object-cover rounded-lg border border-gray-200">
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Preview Script -->
                        <script>
                            function previewImage(input) {
                                const preview = document.getElementById('preview');
                                const previewContainer = document.getElementById('imagePreview');
                                
                                if (input.files && input.files[0]) {
                                    const reader = new FileReader();
                                    
                                    reader.onload = function(e) {
                                        preview.src = e.target.result;
                                        previewContainer.classList.remove('hidden');
                                    }
                                    
                                    reader.readAsDataURL(input.files[0]);
                                } else {
                                    preview.src = '#';
                                    previewContainer.classList.add('hidden');
                                }
                            }
                        </script>

                        <!-- Shipping Warning Script -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const checkbox = document.getElementById('show_in_other_menu');
                                const warningDiv = document.getElementById('shippingWarning');
                                
                                if (checkbox && warningDiv) {
                                    // Initialize visibility
                                    toggleWarning(checkbox.checked);
                                    
                                    // Add change event listener
                                    checkbox.addEventListener('change', function() {
                                        toggleWarning(this.checked);
                                    });
                                }
                                
                                function toggleWarning(show) {
                                    if (show) {
                                        warningDiv.classList.remove('hidden');
                                    } else {
                                        warningDiv.classList.add('hidden');
                                    }
                                }
                            });
                        </script>

                        <!-- Ketersediaan -->
                        <div class="mb-6 space-y-3">
                            <div class="flex items-center p-2 rounded-md hover:bg-gray-50 transition-colors duration-200">
                                <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }} 
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="is_available" class="ml-2 block text-sm text-gray-900 cursor-pointer select-none w-full">
                                    {{ __('Tersedia untuk dipesan') }}
                                </label>
                            </div>
                            <div class="flex items-center p-2 rounded-md bg-gray-50">
                                <input type="checkbox" name="show_in_other_menu" id="show_in_other_menu" value="1" checked disabled 
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded bg-gray-100 cursor-not-allowed">
                                <input type="hidden" name="show_in_other_menu" value="1">
                                <label for="show_in_other_menu" class="ml-2 block text-sm text-gray-500 select-none w-full">
                                    {{ __('Tampilkan di Menu Lainnya') }}
                                </label>
                            </div>
                            <div id="shippingWarning" class="hidden mt-2 ml-6 p-3 bg-pink-50 text-pink-800 text-sm rounded-md border-2 border-red-300">
                                <p class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Harga ongkir akan dibebaskan untuk menu ini.
                                </p>
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Simpan Menu') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 