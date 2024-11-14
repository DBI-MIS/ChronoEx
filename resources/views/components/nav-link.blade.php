@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-current dark:border-current text-sm font-medium leading-5 focus:outline-none focus:border-current transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 hover:border-current dark:hover:border-current focus:outline-none focus:text-current dark:focus:text-currrent focus:border-currrent dark:focus:border-current transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
