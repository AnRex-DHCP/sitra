<div>
    @if($href)
        <a
            href="{{ $href }}"
            class="btn btn-primary btn-label waves-effect waves-light {{ $fullClass }}"
        >
            @if($icon)
                <i class="{{ $icon }} label-icon align-middle fs-16 me-2"></i>
            @endif
            {{ $text }}
        </a>
    @else
        <button
            type="{{ $type }}"
            @if($action) wire:click="{{ $action }}" @endif
            class="btn btn-primary btn-label waves-effect waves-light {{ $fullClass }}"
        >
            @if($icon)
                <i class="{{ $icon }} label-icon align-middle fs-16 me-2"></i>
            @endif
            {{ $text }}
        </button>
    @endif
</div>
