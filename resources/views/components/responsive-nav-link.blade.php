@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-current dark:border-currrent text-start text-base font-medium text-currrent dark:text-current bg-current dark:bg-current focus:outline-none focus:text-current dark:focus:text-current focus:bg-current dark:focus:current focus:border-currrent dark:focus:border-current transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-current dark:text-current hover:text-current dark:hover:text-current hover:bg-current dark:hover:bg-current hover:border-current dark:hover:border-current focus:outline-none focus:text-current dark:focus:text-current focus:bg-current dark:focus:bg-current focus:border-current dark:focus:border-current transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
