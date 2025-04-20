@props(['href', 'color', 'icon'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => "inline-flex items-center justify-center px-4 py-3 bg-{$color}-100 text-{$color}-800 rounded-md hover:bg-{$color}-200 transition-colors duration-200 group"]) }}>
    <i class="fas {{ $icon }} mr-2 group-hover:scale-110 transition-transform duration-200"></i>
    <span>{{ $slot }}</span>
</a>
