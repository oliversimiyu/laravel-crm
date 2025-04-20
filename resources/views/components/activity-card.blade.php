@props(['title', 'color', 'icon'])

<div {{ $attributes->merge(['class' => 'mb-2 p-3 bg-' . $color . '-50 dark:bg-' . $color . '-900/50 rounded-lg border border-' . $color . '-200 dark:border-' . $color . '-800']) }}>
    <div class="flex items-start space-x-3">
        <div class="flex-shrink-0">
            <i class="fas {{ $icon }} text-{{ $color }}-600 dark:text-{{ $color }}-400"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="font-medium text-gray-900 dark:text-gray-100 truncate">{{ $title }}</p>
            {{ $slot }}
        </div>
    </div>
</div>
