<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header bg-light">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Filtros de Módulos</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <form wire:submit.prevent="applyFilters" class="d-flex flex-column justify-content-end h-100">

        <div class="offcanvas-body">
            <div class="mb-4">
                <label for="application" class="form-label text-muted text-uppercase fw-semibold mb-3">Aplicación</label>
                <select class="form-select" wire:model="filters.application_id" id="application">
                    <option value="">Seleccionar Aplicación</option>
                    @foreach($applications as $application)
                        <option value="{{ $application->id }}">{{ $application->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="name" class="form-label text-muted text-uppercase fw-semibold mb-3">Nombre</label>
                <input type="text" class="form-control" id="name" wire:model.defer="filters.name" placeholder="Buscar por nombre">
            </div>

        </div>


        <div class="offcanvas-footer border-top p-3 text-center hstack gap-2">
            <button type="button" class="btn btn-light w-100" wire:click="resetFilters" x-data x-on:click="$nextTick(() => { bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasExample')).hide() })">
                <i class="ri-eraser-line"></i> Limpiar Filtros
            </button>
            <button type="submit" class="btn btn-success w-100" x-data x-on:click="$nextTick(() => { bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasExample')).hide() })">
                <i class="ri-filter-line"></i> Aplicar Filtros
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('closeOffcanvas', () => {
            const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasExample'));
            if (offcanvas) {
                offcanvas.hide();
            }

            // Limpieza adicional
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.offcanvas-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
        });
    });

</script>

