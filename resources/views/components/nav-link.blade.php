@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-3 text-base font-medium text-blue-600 border-b-4 border-blue-600 transition-all duration-200'
            : 'inline-flex items-center px-4 py-3 text-base font-medium text-gray-600 hover:text-gray-900 border-b-4 border-transparent hover:border-gray-400 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
