@props(['food', 'class' => ''])

<div {{ $attributes->merge(['class' => 'relative overflow-hidden ' . $class]) }}>
    <img src="{{ Storage::url($food->image) }}"
         alt="{{ $food->name }}"
         class="w-full h-full object-cover"
         onerror="this.onerror=null; this.src='{{ asset('img/default-food.jpg') }}';">
</div> 