@props(['title', 'value', 'color', 'icon'])

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 relative">
    <div class="flex items-center justify-between">
        <div>
            <div class="text-3xl font-bold {{ $color }}">{{ $value }}</div>
            <div class="text-gray-600 dark:text-gray-400">{{ $title }}</div>
        </div>
        <div class="text-gray-400 dark:text-gray-600">
            <i class="fas {{ $icon }} text-2xl"></i>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 w-full h-1 {{ str_replace('text', 'bg', $color) }} opacity-25"></div>
</div>
