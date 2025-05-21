@props(['food', 'quantity', 'price'])

<div class="flex items-center justify-between text-sm">
    <div class="flex items-center flex-1">
        <div class="flex-shrink-0 w-10 h-10 mr-3">
            <x-food-image :food="$food" class="w-10 h-10 rounded-lg" />
        </div>
        <div>
            <p class="font-medium">{{ $food->name }}</p>
            <p class="text-white/80">Rp {{ number_format($price, 0, ',', '.') }} × {{ $quantity }}</p>
        </div>
    </div>
    <div class="flex items-center space-x-2">
        <button onclick="updateQuantity('{{ $food->id }}', {{ $quantity - 1 }})" 
                class="w-6 h-6 flex items-center justify-center rounded bg-white/20 hover:bg-white/30">
            -
        </button>
        <span>{{ $quantity }}</span>
        <button onclick="updateQuantity('{{ $food->id }}', {{ $quantity + 1 }})"
                class="w-6 h-6 flex items-center justify-center rounded bg-white/20 hover:bg-white/30">
            +
        </button>
    </div>
</div> 