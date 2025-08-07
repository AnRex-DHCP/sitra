<div class="mb-3">
    @if($label)
        <label for="{{ $modelName }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $modelName }}"
        id="{{ $modelName }}"
        class="{{ $defaultClass }} @error($modelName) is-invalid @enderror"
        placeholder="{{ $placeholder }}"
        wire:model.live="{{ $modelName }}"
        @if($required) required @endif
    />

    @error($modelName)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
