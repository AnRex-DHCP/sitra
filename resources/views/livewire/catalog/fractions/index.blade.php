<div>
  <div class="card">

    {{-- Header --}}
    <div class="card-header border border-dashed border-end-0 border-start-0">
      <div class="d-flex align-items-center">
        <h5 class="card-title mb-0 flex-grow-1">
          Mostrando resultados para&nbsp;
          <span class="text-primary fw-medium fst-italic">Fracciones</span>
        </h5>
        <div class="flex-shrink-0">
          <x-button
            type="button"
            color="primary"
            icon="ri-add-line"
            :href="route('fractions.create')"
          >
            Nueva Fracción
          </x-button>
        </div>
      </div>
    </div>

    {{-- Body --}}
    <div class="card-body bg-white">
      @livewire('components.data-table', [
        'query'            => $query->with('article'),
        'columns'          => [
          'article.number' => ['label' => 'Número de Artículo'],
          'article.title'  => ['label' => 'Título de Artículo'], // Opcional
          'code'          => ['label' => 'Código'],
          'description'   => ['label' => 'Descripción'],
          'created_at'    => ['label' => 'Creación', 'width' => '200px'],
        ],
        'searchColumns'    => [
          'article.number',
          'article.title',
          'code',
          'description',
        ],
        'selectColumns'    => ['*'],
        'withRelations'    => ['article'],
        'actions'          => [
          [
            'name'       => 'show',
            'label'      => '',                      
            'icon'       => 'ri-eye-fill',
            'class'      => 'btn-info btn-sm',
            'route'      => 'fractions.show',
            'parameters' => ['id'],
          ],
          [
            'name'       => 'edit',
            'label'      => '',                       {{-- y aquí --}}
            'icon'       => 'ri-pencil-fill',
            'class'      => 'btn-warning btn-sm',
            'route'      => 'fractions.edit',
            'parameters' => ['id'],
          ],
          [
            'name'       => 'delete',
            'label'      => '',                       {{-- y aquí también --}}
            'icon'       => 'ri-delete-bin-fill',
            'class'      => 'btn-danger btn-sm',
            'route'      => 'delete',
            'parameters' => ['id'],
            'confirm'    => '¿Eliminar esta fracción?',
          ],
        ],
        'tableStyle'       => 'bootstrap',
        'moduleName'       => 'Fracciones',
        'moduleIdentifier' => 'fractions',
        'searchPlaceholder' => 'Buscar por num., título, código o descripción',
      ])
    </div>
  </div>

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