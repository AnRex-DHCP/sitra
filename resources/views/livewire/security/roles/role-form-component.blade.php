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
                    <span class="text-primary fw-medium fst-italic">Roles</span>
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
                            :href="route('roles')"
                        >
                            Atrás
                        </x-button>


                    </div>
                </div>
            </div>

        </div>
        {{--Card Header End--}}



        <div class="card-body">
            @if($errorMessage)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errorMessage }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form wire:submit.prevent="save">
            <x-forms.security.roles.role-component-form
                :mode="$mode"
            ></x-forms.security.roles.role-component-form>

            <div class="mt-4">
                <h5 class="mb-3">Permisos</h5>

                <div wire:ignore.self class="accordion custom-accordion" id="permissionsAccordion">
                    @foreach($groupedPermissions as $appId => $app)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $appId }}">
                                <button class="accordion-button fw-medium collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#app{{ $appId }}"
                                        aria-expanded="false"
                                        aria-controls="app{{ $appId }}">
                                    {{ $app['name'] }}
                                </button>
                            </h2>
                            <div id="app{{ $appId }}"
                                 class="accordion-collapse collapse"
                                 wire:ignore.self
                                 aria-labelledby="heading{{ $appId }}">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm mb-0">
                                            <tbody>
                                                @foreach($app['modules'] as $moduleId => $module)
                                                    <tr>
                                                        <td style="width: 200px;" class="align-middle border-0">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                       class="form-check-input module-checkbox"
                                                                       id="module_{{ $moduleId }}"
                                                                       wire:key="module_{{ $moduleId }}"
                                                                       wire:model.live="moduleChecked.{{ $moduleId }}"
                                                                       wire:click="toggleModulePermissions({{ $moduleId }}, $event.target.checked)"
                                                                       @if($this->isModuleFullySelected($moduleId)) checked @endif
                                                                       @if($mode === 'show') disabled @endif>
                                                                <label class="form-check-label fw-medium" for="module_{{ $moduleId }}">
                                                                    {{ $module['name'] }}
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="border-0">
                                                            <div class="d-flex flex-wrap gap-3">
                                                                @foreach($module['permissions'] as $permission)
                                                                    <div class="form-check permission-check" wire:key="perm_{{ $permission['id'] }}">
                                                                        <input type="checkbox"
                                                                               class="form-check-input permission-checkbox"
                                                                               id="permission_{{ $permission['id'] }}"
                                                                               wire:model.live="selectedPermissions"
                                                                               value="{{ $permission['id'] }}"
                                                                               data-module-id="{{ $moduleId }}"
                                                                               @if($mode === 'show') disabled @endif>
                                                                        <label class="form-check-label" for="permission_{{ $permission['id'] }}">
                                                                            {{ $permission['name'] }}
                                                                            @if($permission['description'])
                                                                                <i class="ri-information-line text-muted"
                                                                                   data-bs-toggle="tooltip"
                                                                                   title="{{ $permission['description'] }}"></i>
                                                                            @endif
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            </form>

        </div>
    </div>
</div>

@push('css')
<style>
    .custom-accordion .accordion-item {
        border-radius: 4px;
        margin-bottom: 0.5rem;
        border: 1px solid rgba(0,0,0,.125);
    }

    .custom-accordion .accordion-button {
        padding: 0.75rem 1.25rem;
    }

    .custom-accordion .accordion-button:not(.collapsed) {
        background-color: rgba(0,0,0,.03);
    }

    .permission-check {
        min-width: 200px;
        margin-bottom: 0.5rem;
    }

    .accordion-body {
        padding: 1rem;
    }

    .table > :not(caption) > * > * {
        padding: 0.5rem;
    }
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeAccordion();
    updateModuleCheckboxes();

    Livewire.on('permissions-updated', function() {
        updateModuleCheckboxes();
    });

    Livewire.on('modulePermissionsToggled', function(event) {
        const moduleCheckbox = document.querySelector(`#module_${event.moduleId}`);
        if (moduleCheckbox) {
            moduleCheckbox.checked = event.checked;
        }
        updateModuleCheckboxes();
    });
});

function updateModuleCheckboxes() {
    requestAnimationFrame(() => {
        document.querySelectorAll('.module-checkbox').forEach(function(moduleCheckbox) {
            const moduleId = moduleCheckbox.id.replace('module_', '');
            const permissions = document.querySelectorAll(`.permission-checkbox[data-module-id="${moduleId}"]`);
            const allChecked = Array.from(permissions).every(p => p.checked);
            moduleCheckbox.checked = allChecked;
        });
    });
}

// Modificar el checkbox del módulo para que actualice inmediatamente
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('module-checkbox')) {
        e.target.checked = e.target.checked; // Forzar actualización visual
    }
});

function initializeAccordion() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Obtener todos los acordeones
    const accordions = document.querySelectorAll('.accordion-collapse');

    // Restaurar estado de los acordeones
    accordions.forEach(function(accordion) {
        const isOpen = sessionStorage.getItem('accordion_' + accordion.id) === 'open';
        if (isOpen) {
            new bootstrap.Collapse(accordion, { toggle: false }).show();
        }
    });

    // Escuchar eventos de acordeón
    accordions.forEach(function(accordion) {
        accordion.addEventListener('show.bs.collapse', function() {
            sessionStorage.setItem('accordion_' + this.id, 'open');
        });

        accordion.addEventListener('hide.bs.collapse', function() {
            sessionStorage.setItem('accordion_' + this.id, 'closed');
        });
    });

    // Prevenir cierre del acordeón al interactuar con checkboxes
    document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
        checkbox.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
}

// Agregar manejador de eventos para los checkboxes de permisos individuales
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('permission-checkbox')) {
        updateModuleCheckboxes();
    }
});
</script>
@endpush
