@props([
    'type' => 'button',
    'color' => 'primary',
    'size' => '',
    'outline' => false,
    'block' => false,
    'icon' => '',
    'iconPosition' => 'left',
    'loading' => false,
    'disabled' => false,
    'href' => null
])

@php
    $baseClass = 'btn';
    $sizeClass = $size ? "btn-$size" : '';
    $colorClass = $outline ? "btn-outline-$color" : "btn-$color";
    $effectClass = "btn-label waves-effect waves-light";
    $blockClass = $block ? 'w-100' : '';
    $loadingClass = $loading ? 'disabled' : '';
    $icon.= " label-icon align-middle fs-16 me-2";

    $classes = trim("$baseClass $colorClass $sizeClass $blockClass $loadingClass $effectClass");
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')
            <i class="{{ $icon }} me-1"></i>
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }} ms-1"></i>
        @endif
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if($disabled || $loading) disabled @endif
    >
        @if($loading)
            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
        @else
            @if($icon && $iconPosition === 'left')
                <i class="{{ $icon }} me-1"></i>
            @endif
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right' && !$loading)
            <i class="{{ $icon }} ms-1"></i>
        @endif
    </button>
@endif
