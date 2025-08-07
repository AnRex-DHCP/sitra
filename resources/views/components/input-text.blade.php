@props([
    'name' => '',
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'prefix' => '',
    'defaultClass' => 'form-control',
    'mode'=> ''
])

@php
    $fullName = $prefix ? "{$prefix}.{$name}" : $name;
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $fullName }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $fullName }}"
        id="{{ $fullName }}"
        class="{{ $defaultClass }} @error($fullName) is-invalid @enderror"
        placeholder="{{ $placeholder }}"
        wire:model.live="{{ $fullName }}"
        @if($required) required @endif
        @if($mode=="show") disabled @endif
        {{ $attributes }}
    />

    @error($fullName)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
