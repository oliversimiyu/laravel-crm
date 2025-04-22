@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'auth-input', 'rows' => '4']) !!}></textarea>
