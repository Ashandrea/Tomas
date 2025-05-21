<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ubah Menu Makanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('foods.update', $food) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nama') }}</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" value="{{ old('name', $food->name) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Deskripsi') }}</label>
                            <div class="mt-1">
                                <textarea name="description" id="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('description', $food->description) }}</textarea>
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
                                <input type="number" name="price" id="price" value="{{ old('price', $food->price) }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Gambar Saat Ini') }}</label>
                            <div class="mt-1">
                                <img src="{{ $food->image_url }}" alt="{{ $food->name }}" class="h-32 w-32 object-cover rounded-lg">
                            </div>
                        </div>

                        <!-- New Image -->
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700">{{ __('Gambar Baru') }}</label>
                            <div class="mt-1">
                                <input type="file" name="image" id="image" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Availability -->
                        <div class="mb-6">
                            <div class="flex items-center">
                                <input type="hidden" name="is_available" value="0">
                                <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', $food->is_available) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="is_available" class="ml-2 block text-sm text-gray-900">
                                    {{ __('Tersedia untuk dipesan') }}
                                </label>
                            </div>
                        </div>
                        


                        <!-- Buttons -->
                        <div class="flex justify-end space-x-4">
                            <!-- Cancel Button -->
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Batal') }}
                            </a>
                            
                            <!-- Delete Button -->
                            <button type="button" 
                                    onclick="if(confirm('Apakah Anda yakin ingin menghapus menu ini?')) { document.getElementById('delete-form').submit(); }" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                {{ __('Hapus') }}
                            </button>
                            
                            <!-- Update Button -->
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Perbarui Menu') }}
                            </button>
                        </div>
                    </form>
                    
                    <!-- Hidden Delete Form -->
                    <form id="delete-form" action="{{ route('foods.destroy', $food) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 