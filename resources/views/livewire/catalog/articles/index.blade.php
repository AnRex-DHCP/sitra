<div> {{-- ← Único elemento raíz --}}

  <div class="card">
    {{-- Cabecera “Mostrando resultados para Artículos” + botón Crear --}}
    <div class="card-header border border-dashed border-end-0 border-start-0">
      <div class="d-flex align-items-center">
        <h5 class="card-title mb-0 flex-grow-1">
          Mostrando resultados para&nbsp;
          <span class="text-primary fw-medium fst-italic">Artículos</span>
        </h5>
        <div class="flex-shrink-0">
          <x-button
            type="button"
            color="primary"
            icon="ri-add-line"
            :href="route('articles.create')"
          >
            Crear Artículo
          </x-button>
        </div>
      </div>
    </div>

    {{-- Cuerpo con fondo blanco: DataTable --}}
    <div class="card-body bg-white">
      @livewire('components.data-table', [
          'query'            => $query,
          'columns'          => [
              'number'     => ['label' => 'Número'],
              'title'      => ['label' => 'Título'],
              'created_at' => ['label' => 'Fecha Creación', 'width' => '200px'],
          ],
          'actions'          => [
            ['name'=>'show','label'=>'','icon'=>'ri-eye-fill','class'=>'btn-info btn-sm','route'=>'articles.show','parameters'=>['id']],
            ['name'=>'edit','label'=>'','icon'=>'ri-pencil-fill','class'=>'btn-warning btn-sm','route'=>'articles.edit','parameters'=>['id']],
            ['name'=>'delete','label'=>'','icon'=>'ri-delete-bin-fill','class'=>'btn-danger btn-sm','route'=>'delete','parameters'=>['id'],'confirm'=>'¿Eliminar este artículo?'],
          ],
          'searchColumns'    => ['number','title'],
          'selectColumns'    => ['id','number','title','created_at'],
          'tableStyle'       => 'bootstrap',
          'moduleName'       => 'Artículos',
          'moduleIdentifier' => 'articles',
          'searchPlaceholder' => 'Buscar por número o título',
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
