<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">
            @if($mode==='show')
                Visualizar Área
            @elseif($areaId)
                Editar Área
            @else
                Crear Área
            @endif
        </h4>
        <div>
            @if($mode!=='show')
                <button type="submit" form="areaForm" class="btn btn-primary me-2">
                    <i class="ri-save-line me-1"></i> Guardar
                </button>
            @endif

            <button type="button" wire:click="cancel" class="btn btn-secondary">
                <i class="ri-arrow-left-line me-1"></i> Atrás
            </button>
        </div>
    </div>

    <div class="card-body">
        {{-- Mensajes de error/success --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form id="areaForm" wire:submit.prevent="save">
            {{-- Nombre --}}
            <div class="mb-3">
                <label>Nombre de Área</label>
                <input
                    wire:model.defer="name"
                    class="form-control"
                    @if($mode==='show') disabled @endif
                >
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            {{-- Área Padre --}}
            <div class="mb-3">
                <label>Escoger Área</label>
                <select
                    wire:model.defer="parent_id"
                    class="form-control"
                    @if($mode==='show' || $hasSubareas) disabled @endif
                >
                    <option value="">-- Área Principal --</option>
                    @foreach($areasHierarchy as $area)
                        <option value="{{ $area['id'] }}">{{ $area['label'] }}</option>
                    @endforeach
                </select>
                @if($hasSubareas && $mode !== 'show')
                    <div class="alert alert-warning mt-2">
                        Esta área contiene subáreas. Elimínalas o muévelas antes de cambiar el área principal.
                    </div>
                @endif
                @error('parent_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </form>
    </div>
</div>
