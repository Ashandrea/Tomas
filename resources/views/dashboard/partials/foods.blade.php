<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3">
    @foreach($foods as $food)
        <div class="border rounded-lg p-2 shadow-sm">
            @if($food->image)
                <img src="{{ Storage::url($food->image) }}" alt="{{ $food->name }}" class="w-full h-20 object-cover rounded-lg mb-1">
            @endif
            <h4 class="font-medium text-xs truncate">{{ $food->name }}</h4>
            <p class="text-[10px] text-gray-500 truncate">{{ __('From:') }} {{ $food->seller->name }}</p>
            <p class="text-sm font-semibold mt-0.5">Rp {{ number_format($food->price, 0, ',', '.') }}</p>
            <div class="inline-flex items-center mt-1 bg-pink-200 px-2 py-0.5 rounded-lg text-xs w-fit">
                <span class="font-semibold text-gray-700">{{ number_format($food->average_rating ?? 0, 1) }}</span>
                <svg class="w-3 h-3 text-red-700 ml-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37-2.448c-.784.57-1.838-.197-1.54-1.118l1.287-3.957a1 1 0 00-.364-1.118L2.01 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z" />
                </svg>
            </div>
            <a href="{{ route('orders.create') }}" class="mt-1 inline-block bg-indigo-600 text-white px-2 py-0.5 rounded-lg hover:bg-indigo-700 text-xs">
                {{ __('Order Now') }}
            </a>
        </div>
    @endforeach
</div>
