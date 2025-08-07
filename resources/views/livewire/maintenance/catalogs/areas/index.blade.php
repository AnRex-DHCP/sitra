<div>
  <div class="card">
    <div class="card-header border border-dashed border-end-0 border-start-0">
      <div class="d-flex align-items-center">
        <h5 class="card-title mb-0 flex-grow-1">
          Mostrando resultados para&nbsp;
          <span class="text-primary fw-medium fst-italic">Áreas</span>
        </h5>
        <div class="flex-shrink-0">
          <x-button
            type="button"
            color="primary"
            icon="ri-add-line"
            :href="route('maintenance-areas.create')"
          >
            Crear Área
          </x-button>

          <x-button
            color="info"
            icon="ri-equalizer-fill"
            data-bs-toggle="offcanvas"
            href="#offcanvasAreasFilter"
          >
            Filtros
          </x-button>
      </div>
      </div>
    </div>

    <div class="card-body bg-white">
      @livewire('components.data-table', [
        'query' => $query->with('parent.parent'),
        'columns' => [
          'name'  => ['label' => 'Nombre de Área','sortable' => true],
          'parent_full_name' => ['label' => 'Áreas','default' => '—','sortable' => false],
          'created_at'  => ['label' => 'Creación', 'width' => '200px','sortable' => true],
        ],
        'searchColumns' => [
          'name',
          'parent.name',
        ],
        'selectColumns' => ['*'],
        'withRelations' => ['parent'],
        'actions' => [
          [
            'name' => 'show',
            'label' => '', 
            'icon' => 'ri-eye-fill',
            'class' => 'btn-info btn-sm',
            'route' => 'maintenance-areas.show',
            'parameters' => ['id'],
          ],
          [
            'name' => 'edit',
            'label' => '', 
            'icon' => 'ri-pencil-fill',
            'class' => 'btn-warning btn-sm',
            'route' => 'maintenance-areas.edit',
            'parameters' => ['id'],
          ],
          [
            'name' => 'delete',
            'label' => '', 
            'icon' => 'ri-delete-bin-fill',
            'class' => 'btn-danger btn-sm',
            'route' => 'delete',
            'parameters' => ['id'],
            'confirm' => '¿Eliminar esta área?',
          ],
        ],
        'tableStyle' => 'bootstrap',
        'moduleName' => 'Áreas',
        'moduleIdentifier' => 'areas',
        'searchPlaceholder' => 'Buscar por nombre de área o áreas',
      ])
    </div>
  </div>
    @livewire('maintenance.catalogs.areas.areas-filter', ['moduleIdentifier' => 'areas'])

{{-- SweetAlert utils para confirmación de borrado --}}
  @push('js')
    <script src="{{ asset('js/sweetalert-utils.js') }}"></script>
  @endpush

  @push('scripts')
    <script>
      Livewire.on('recordDeletedConfirm', itemId => {
        SweetAlertUtils.showDeleteConfirmation(itemId).then((result) => {
          if (result.isConfirmed) {
            Livewire.dispatch('recordDeleted', { id: itemId });
            SweetAlertUtils.showDeleteSuccess(false);
          }
          });
      });
    </script>
  @endpush
</div>