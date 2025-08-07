<div>
    <div class="card">
        {{--Card Header Start--}}
        <div class="card-header border border-dashed border-end-0 border-start-0">

            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    Mostrando resultados para <span class="text-primary fw-medium fst-italic">{{ $moduleName  }}</span>
                </h5>
                <div class="flex-shrink-0">
                    <div class="d-flex flex-wrap gap-2">

                        @if(!empty($selectedItems))
                            <x-button
                                color="danger"
                                icon="ri-delete-bin-2-line"
                                wire:click="confirmDeleteMultiple"
                            >
                                Eliminar seleccionados
                            </x-button>
                        @endif

                        <x-button
                            color="primary"
                            icon="ri-add-line"
                            :href="route('applications.create')"
                        >
                            Crear Aplicación
                        </x-button>


                    </div>
                </div>
            </div>

        </div>
        {{--Card Header End--}}

        {{--Card Body Start--}}
        <div class="card-body">
            @livewire('components.data-table', [
                'query' => $tableData['query'],
                'columns' => $tableData['columns'],
                'actions' => $tableData['actions'],
                'searchColumns' => $tableData['searchColumns'],
                'selectColumns' => $tableData['selectColumns'],
                'tableStyle' => $tableStyle,
                'moduleName' => 'Permisos',
                'moduleIdentifier' => 'permissions'
            ])
        </div>
        {{--Card Body End--}}

    </div>
    @livewire('security.permissions.permissions-filter', ['moduleIdentifier' => 'permissions'])
</div>

@push('js')
    <script src="{{ asset('js/sweetalert-utils.js') }}"></script>
@endpush
@push('scripts')
    Livewire.on('recordDeletedConfirm', itemId => {
    SweetAlertUtils.showDeleteConfirmation(itemId).then((result) => {
    if (result.isConfirmed) {
    Livewire.dispatch('recordDeleted', { id: itemId });
    SweetAlertUtils.showDeleteSuccess(false);
    }
    });
    });

    Livewire.on('confirmDeleteMultiple', () => {
    SweetAlertUtils.showDeleteConfirmation().then((result) => {
    if (result.isConfirmed) {
    Livewire.dispatch('deleteMultiple');
    SweetAlertUtils.showDeleteSuccess(true);
    }
    });
    });


@endpush
