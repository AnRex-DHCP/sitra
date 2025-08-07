@props([
    'name',
    'id' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Seleccione una opción',
    'multiple' => false,
    'required' => false,
    'label' => null,
    'disabled' => false,
    'prefix' => null,
    'mode'=> ''
])

@php
    $id = $id ?? $name;
    $modelName = $prefix ? "{$prefix}.{$name}" : $name;
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $id }}"
        wire:model.live="{{ $modelName }}"
        {{ $multiple ? 'multiple' : '' }}
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        data-choices
        {{ $attributes->merge(['class' => 'form-control']) }}
        @if($mode=="show") disabled @endif
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $key => $value)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>

    @error($modelName)
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>

@push('scripts')
    document.addEventListener('DOMContentLoaded', function() {
        const element = document.querySelector('#{{ $id }}');
        const choices = new Choices(element, {
            removeItemButton: true,
            searchEnabled: true,
            placeholder: true,
            placeholderValue: '{{ $placeholder }}',
            itemSelectText: 'Presiona para seleccionar',

            @if($multiple)
            removeItems: true,
            removeItemButton: true,
            @endif
        });

        // Sincronización con Livewire
        element.addEventListener('change', function(event) {
            @this.set('{{ $modelName }}', event.target.value);
        });

        // Actualizar Choices cuando Livewire actualiza el valor
        window.addEventListener('livewire:initialized', () => {
            @this.on('{{ $modelName }}-updated', (value) => {
                choices.setChoiceByValue(value);
            });
        });
    });
@endpush
