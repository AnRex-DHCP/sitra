<div class="card">
  {{-- HEADER con título y botones --}}
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-0">
      @if($mode==='show')
        Visualizar Artículo
      @elseif($articleId)
        Editor de Artículo
      @else
        Crear Artículo
      @endif
    </h4>
    <div>
      @if($mode!=='show')
        <button
          type="submit"
          form="articleForm"
          class="btn btn-primary me-2"
        >
          <i class="ri-save-line me-1"></i> Guardar
        </button>
      @endif
      <button
        type="button"
        wire:click="cancel"
        class="btn btn-secondary"
      >
        <i class="ri-arrow-left-line me-1"></i> Atrás
      </button>
    </div>
  </div>

  {{-- CUERPO con el <form> --}}
  <div class="card-body">
    <form id="articleForm" wire:submit.prevent="save">
      {{-- Número --}}
      <div class="mb-3">
        <label>Número</label>
        <input
          wire:model.defer="number"
          class="form-control"
          @if($mode==='show') disabled @endif
        >
        @error('number')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      {{-- Título --}}
      <div class="mb-3">
        <label>Título</label>
        <input
          wire:model.defer="title"
          class="form-control"
          @if($mode==='show') disabled @endif
        >
        @error('title')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
    </form>
  </div>
</div>
