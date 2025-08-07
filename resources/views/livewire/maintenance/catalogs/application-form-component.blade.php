<div>
    <div class="card">

        {{--Card Header Start--}}
        <div class="card-header border border-dashed border-end-0 border-start-0">

            <div class="d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">
                    @if($mode === 'show')
                        Ver
                    @elseif($mode === 'edit')
                        Editar
                    @else
                        Crear
                    @endif
                    <span class="text-primary fw-medium fst-italic">Aplicación</span>
                </h5>
                <div class="flex-shrink-0">
                    <div class="d-flex flex-wrap gap-2">

                        <x-button
                            type="button"
                            class="btn btn-primary"
                            icon="ri-save-fill"
                            x-data
                            @click="$dispatch('submit-form')"
                        >
                            {{ $mode === 'edit' ? 'Actualizar' : 'Guardar' }}
                        </x-button>

                        <x-button
                            color="soft-dark"
                            class="fs-14"
                            icon="ri-arrow-go-back-line"
                            :href="route('applications')"
                        >
                            Atrás
                        </x-button>


                    </div>
                </div>
            </div>

        </div>
        {{--Card Header End--}}

        {{--Card Body Start--}}
        <div class="card-body">
            @if($errorMessage)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errorMessage }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


            <x-forms.maintenance.catalogs.component-form
                :mode="$mode"
            ></x-forms.maintenance.catalogs.component-form>
        </div>
        {{--Card Body End--}}
    </div>
</div>
