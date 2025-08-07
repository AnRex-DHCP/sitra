<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            @if($mode === 'show')
                                Ver Permiso
                            @elseif($mode === 'edit')
                                Editar Permiso
                            @else
                                Crear Permiso
                            @endif
                        </h5>
                        <div class="flex-shrink-0">
                            <a href="{{ route('permissions') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line align-bottom me-1"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="row g-3">
                            <!-- Aplicación -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="application_id" class="form-label">
                                        Aplicación <span class="text-danger">*</span>
                                    </label>
                                    <select wire:model.live="form.application_id"
                                            class="form-select @error('form.application_id') is-invalid @enderror"
                                            @if($mode === 'show') disabled @endif>
                                        <option value="">Seleccione una aplicación</option>
                                        @foreach($applications as $application)
                                            <option value="{{ $application->id }}">
                                                {{ $application->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('form.application_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Módulo -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="permission_module_id" class="form-label">
                                        Módulo <span class="text-danger">*</span>
                                    </label>
                                    <select wire:model="form.permission_module_id"
                                            class="form-select @error('form.permission_module_id') is-invalid @enderror"
                                            @if(!$form->application_id || $mode === 'show') disabled @endif>
                                        <option value="">Seleccione un módulo</option>
                                        @foreach($modules as $module)
                                            <option value="{{ $module->id }}">
                                                {{ $module->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('form.permission_module_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nombre -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        Nombre <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           wire:model="form.name"
                                           class="form-control @error('form.name') is-invalid @enderror"
                                           placeholder="Nombre del permiso"
                                           @if($mode === 'show') disabled @endif>
                                    @error('form.name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="description" class="form-label">
                                        Descripción <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           wire:model="form.description"
                                           class="form-control @error('form.description') is-invalid @enderror"
                                           placeholder="Descripción del permiso"
                                           @if($mode === 'show') disabled @endif>
                                    @error('form.description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if($mode !== 'show')
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button"
                                                class="btn btn-secondary"
                                                wire:click="$dispatch('cancel')">
                                            Cancelar
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            {{ $mode === 'edit' ? 'Actualizar' : 'Guardar' }} Permiso
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
