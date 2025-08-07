<div class="dataTables_wrapper dt-bootstrap5 no-footer">
    {{-- Filtros y Controles --}}

{{--    <div class="row justify-content-center mb-4">
        <div class="col-lg-12">
            <h5 class="fs-16 fw-semibold text-center mb-0">Mostrando resultados para "<span class="text-primary fw-medium fst-italic">{{ $moduleName  }}</span> "</h5>
        </div>
    </div>--}}

    <div class="row g-3 align-items-center mb-4">
        <div class="col-sm-3">
            <div class="search-box">
                @if(isset($searchColumns) && count($searchColumns) > 0)
                    <div class="search-box">
                        <input type="text"
                               wire:model.live="search"
                               class="{{ $tableConfig['search_class'] }} w-100"
                                style="min-width:350px; max-width:100%; width: 570px;"
                               placeholder="{{ $searchPlaceholder ?? 'Buscar...' }}"
                               >
                        <i class="ri-search-line search-icon"></i>
                    </div>
                @endif
            </div>

        </div>
        <div class="col-sm-auto ms-auto">
            <div class="hstack gap-2">


                <select wire:model.live="perPage" class="{{ $tableConfig['per_page_class'] }}">
                    <option value="5">Mostrar 5</option>
                    <option value="10">Mostrar 10</option>
                    <option value="25">Mostrar 25</option>
                    <option value="50">Mostrar 50</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-12 col-md-12">
            <div class="{{ $tableConfig['wrapper_class'] }}">
                <table class="{{ $tableConfig['table_class'] }}">
                    {{-- En el thead --}}
                    <thead class="{{ $tableConfig['thead_class'] }}">
                        <tr>
                            <th class="{{ $tableConfig['th_class'] }}" style="width: 50px;">
                                <div class="form-check">
                                    <input type="checkbox"
                                           class="form-check-input"
                                           wire:model.live="selectAll"
                                           id="selectAll">
                                </div>
                            </th>
                            {{--Autoincremento Número de fila--}}
                            {{--<th class="{{ $tableConfig['th_class'] }}" style="width: 50px;">#</th>--}}
                            @foreach($columns as $key => $column)
                                <th class="{{ $tableConfig['th_class'] }}"
                                    wire:click="sortBy('{{ $key }}')"
                                    style="width: {{ isset($column['width']) ? $column['width'] : 'auto' }};
                                           text-align: {{ isset($column['align']) ? $column['align'] : 'left' }}">
                                    {{ is_array($column) ? $column['label'] : $column }}
                                    @if($sortField === $key)
                                        <i class="ri-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-line"></i>
                                    @endif
                                </th>
                            @endforeach
                            @if(count($actions) > 0)
                                <th class="{{ $tableConfig['th_class'] }}" style="text-align: center; width:100px">Acciones</th>
                            @endif
                        </tr>
                    </thead>

                    {{-- En el tbody --}}
                    <tbody>
    @foreach($data as $index => $item)
        <tr class="{{ $tableConfig['tr_class'] }}">
            <td class="{{ $tableConfig['td_class'] }}">
                <div class="form-check">
                    <input type="checkbox"
                        class="form-check-input"
                        wire:model.live="selectedItems"
                        value="{{ $item->id }}">
                </div>
            </td>
            {{-- Nombre de Área --}}
            <td class="{{ $tableConfig['td_class'] }}">
                @if(is_null($item->parent_id))
                    <strong>{{ $item->name }}</strong>
                @else
                    <em>{{ $item->name }}</em>
                @endif
            </td>
            {{-- Jerarquía de padres --}}
            <td class="{{ $tableConfig['td_class'] }}">
                {{ $item->parent_full_name ?? '—' }}
            </td>
            {{-- Otros campos, como fecha de creación --}}
            <td class="{{ $tableConfig['td_class'] }}">
                {{ $item->created_at }}
            </td>
            {{-- Acciones --}}
            @if(count($actions) > 0)
                <td class="{{ $tableConfig['td_class'] }}" style="text-align: center">
                    <div class="{{ $tableConfig['action_wrapper_class'] }}">
                        @foreach($actions as $action)
                            <button
                                class="{{ $tableConfig['action_button_class'] }} {{ $action['class'] ?? 'btn-primary' }}"
                                @if(isset($action['confirm']))
                                    wire:click="$dispatch('recordDeletedConfirm', {{ $item->id }})"
                                @else
                                    wire:click="executeAction('{{ $action['route'] }}', {{ $item->id }})"
                                @endif
                            >
                                @if(isset($action['icon']))
                                    <i class="{{ $action['icon'] }}"></i>
                                @endif
                                {{ $action['label'] }}
                            </button>
                        @endforeach
                    </div>
                </td>
            @endif
        </tr>
    @endforeach
</tbody>

                </table>

                @if($data->isEmpty())
                    @livewire('components.empty-state')
                @endif

            </div>
        </div>
    </div>

    {{-- Paginación --}}
    <div class="row justify-content-between align-items-center mb-5">
        <div class="col-sm-12 col-md-6 text-muted">
            Mostrando {{ $data->firstItem() ?? 0 }} a {{ $data->lastItem() ?? 0 }} de {{ $data->total() }} resultados
        </div>
        <div class="col-sm-12 col-md-6 align-items-center">
            {{ $data->links($paginationView) }}
        </div>
    </div>




</div>
