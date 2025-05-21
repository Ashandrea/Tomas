<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6 text-indigo-700">Student Showcases</h1>
        @if($showcases->isEmpty())
            <div class="text-center text-gray-500 py-12">No student showcases available.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($showcases as $showcase)
                    <div class="border rounded-lg p-6 relative flex flex-col items-start bg-white shadow-lg">
                        <div class="absolute top-4 right-4 w-16 h-16 rounded-full overflow-hidden border-4 border-white shadow-md">
                            <img src="{{ asset('storage/foods/Model A4-4.jpeg') }}" alt="Student Showcase" class="w-full h-full object-cover">
                        </div>
                        @if($showcase->image)
                            <img src="{{ asset('storage/' . $showcase->image) }}" alt="{{ $showcase->title }}" class="w-full h-32 object-cover rounded-lg mb-4">
                        @else
                            <img src="{{ asset('storage/foods/Model A4-4.jpeg') }}" alt="Default Showcase" class="w-full h-32 object-cover rounded-lg mb-4">
                        @endif
                        <h4 class="font-medium text-xs pr-12 mt-2">{{ $showcase->title }}</h4>
                        <p class="text-[10px] text-gray-500 mb-2">By: {{ $showcase->student ? $showcase->student->name : '-' }}</p>
                        <p class="text-xs text-gray-500 line-clamp-2 mb-2">{{ $showcase->description }}</p>
                        <a href="#" class="mt-auto inline-block bg-indigo-600 text-white px-3 py-1 rounded-lg hover:bg-indigo-700 text-xs w-full text-center">Lihat Showcase</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>