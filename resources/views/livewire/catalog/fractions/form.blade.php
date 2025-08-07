<div class="card">
  {{-- HEADER con título y botones --}}
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4 class="card-title mb-0">
      @if($mode==='show')
        Visualizar Fracción
      @elseif($fractionId)
        Editar Fracción
      @else
        Crear Fracción
      @endif
    </h4>
    <div>
      @if($mode!=='show')
        <!-- IMPORTANTE: type="submit" y form="fractionForm" -->
        <button
          type="submit"
          form="fractionForm"
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
    <form
      id="fractionForm"
      wire:submit.prevent="save"
    >
      {{-- Artículo --}}
      <div class="mb-3">
        <label>Artículo</label>
        <select
          wire:model.defer="article_id"
          class="form-control"
          @if($mode==='show') disabled @endif
        >
          <option value="">-- Selecciona artículo --</option>
          @foreach($articlesList as $art)
            <option value="{{ $art->id }}">
              {{ $art->number }} — {{ $art->title }}
            </option>
          @endforeach
        </select>
        @error('article_id')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      {{-- Código --}}
      <div class="mb-3">
        <label>Código</label>
        <input
          wire:model.defer="code"
          class="form-control"
          @if($mode==='show') disabled @endif
        >
        @error('code')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      {{-- Descripción --}}
      <div class="mb-3">
        <label>Descripción</label>
        <input
          wire:model.defer="description"
          class="form-control"
          @if($mode==='show') disabled @endif
        >
        @error('description')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
    </form>
  </div>
</div>
