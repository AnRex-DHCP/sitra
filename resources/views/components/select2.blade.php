@props([
    'name',
    'id' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Seleccione una opción',
    'multiple' => false,
    'required' => false,
    'label' => null,
    'disabled' => false
])

@php
    $id = $id ?? $name;
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $id }}"
        {{ $multiple ? 'multiple' : '' }}
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => 'js-example-basic-single']) }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

@push('scripts')

        $(document).ready(function() {
            $('#{{ $id }}').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: '{{ $placeholder }}',
                allowClear: true,
                dropdownParent: $('#{{ $id }}').parent()
            });
        });

@endpush
