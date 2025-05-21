<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pengaturan Akun') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cover Photo Section -->
            <div class="relative mb-6 overflow-hidden rounded-lg shadow-md" style="height: 200px;">
                @if(Auth::user()->cover_photo)
                    <img src="{{ Storage::url(Auth::user()->cover_photo) }}" alt="Cover Photo" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">Tidak ada foto sampul</span>
                    </div>
                @endif
                <div class="absolute top-4 right-4">
                    <form action="{{ route('profile.update.cover') }}" method="POST" enctype="multipart/form-data" class="relative">
                        @csrf
                        @method('PATCH')
                        <input type="file" name="cover_photo" id="cover_photo" class="hidden" onchange="this.form.submit()" accept="image/*">
                        <label for="cover_photo" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-90 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#213448] cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ Auth::user()->cover_photo ? 'Ubah Sampul' : 'Unggah Sampul' }}
                        </label>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Sidebar -->
                        <div class="md:col-span-1">
                            <div class="space-y-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm font-medium text-white bg-[#213448] rounded-md">
                                    {{ __('Profil') }}
                                </a>
                            </div>
                        </div>
                        <!-- Main Content -->
                        <div class="md:col-span-3">
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('Informasi Profil') }}</h3>
                                
                                <!-- Profile Photo -->
                                <div class="flex items-center mb-6">
                                    <div class="mr-4">
                                        @if(Auth::user()->profile_photo)
                                            <img src="{{ Storage::url(Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="h-16 w-16 rounded-full object-cover">
                                        @else
                                            <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-2xl font-bold text-gray-600">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <form action="{{ route('profile.update.photo') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex items-center space-x-2">
                                                <input type="file" name="photo" id="photo" class="hidden" onchange="this.form.submit()">
                                                <label for="photo" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#213448] cursor-pointer">
                                                    {{ __('Unggah Foto') }}
                                                </label>
                                                @if(Auth::user()->profile_photo)
                                                <button type="button" onclick="event.preventDefault(); document.getElementById('delete-photo-form').submit();" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    {{ __('Hapus') }}
                                                </button>
                                                @endif
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ __('Format: JPG, PNG. Maksimal: 2MB') }}
                                            </p>
                                        </form>
                                    </div>
                                </div>


                                <!-- Delete Photo Form (Hidden) -->
                                @if(Auth::user()->profile_photo)
                                <form id="delete-photo-form" action="{{ route('profile.update.photo') }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif

                                <!-- Profile Information -->
                                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <div class="grid grid-cols-1 gap-6 mt-6">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Nama Lengkap') }}</label>
                                            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#213448] focus:ring focus:ring-[#213448] focus:ring-opacity-50">
                                            @error('name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Alamat Email') }}</label>
                                            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#213448] focus:ring focus:ring-[#213448] focus:ring-opacity-50">
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('Nomor Telepon') }}</label>
                                            <input type="text" name="phone" id="phone" value="{{ old('phone', Auth::user()->phone) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#213448] focus:ring focus:ring-[#213448] focus:ring-opacity-50">
                                            @error('phone')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="submit" class="px-4 py-2 bg-[#213448] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1a2a38] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#213448] transition ease-in-out duration-150">
                                                {{ __('Simpan Perubahan') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
