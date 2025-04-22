@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'auth-input bg-gray-800 border-gray-700 text-white focus:border-blue-500 focus:ring-blue-500', 'rows' => '4']) !!}></textarea>
