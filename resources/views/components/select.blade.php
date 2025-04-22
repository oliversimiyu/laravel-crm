@props(['disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'auth-input']) !!}>
    {{ $slot }}
</select>
