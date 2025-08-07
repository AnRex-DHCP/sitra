<?php

namespace App\Livewire\Maintenance\Catalogs\Areas;

use Livewire\Component;
use App\Models\Area;
use Illuminate\Validation\Rule;

class AreaForm extends Component
{
    public $areaId;
    public $name;
    public $parent_id;
    public $mode = 'create';
    public $areasList;
    public $hasSubareas = false; // Para bloquear edición de áreas padre si tiene hijos

    public function mount($id = null, $mode = null)
    {
        $this->areasList = Area::orderBy('name')->get();

        if ($mode) {
            $this->mode = $mode;
        }

        if ($id) {
            $this->areaId = $id;
            $area = Area::findOrFail($id);
            $this->name = $area->name;
            $this->parent_id = $area->parent_id;
            $this->hasSubareas = $area->children()->exists();
        }
    }

    protected function rules()
    {
        return [
            'name' => [
                'required', 'string', 'max:100',
                // UNIQUE CONSIDERANDO ÁREAS PRINCIPALES Y SUBÁREAS
                Rule::unique('areas')->where(function ($query) {
                    // Para comparar insensible a mayúsculas/minúsculas
                    $query->whereRaw('LOWER(name) = ?', [mb_strtolower($this->name)]);
                    if ($this->parent_id) {
                        $query->where('parent_id', $this->parent_id);
                    } else {
                        $query->whereNull('parent_id');
                    }
                    return $query;
                })->ignore($this->areaId)
            ],
            'parent_id' => ['nullable', 'exists:areas,id'],
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.unique'   => 'Ya existe un área con ese nombre en este nivel.',
        ];
    }

    public function save()
    {
        if ($this->mode === 'show') return;

        $data = $this->validate();

        // --- CORRECCIÓN PRINCIPAL ---
        // Si el valor es '', se asigna null para evitar error SQL
        if (array_key_exists('parent_id', $data) && $data['parent_id'] === '') {
            $data['parent_id'] = null;
        }

        // Si el área actual tiene subáreas, no permitir cambio de padre
        if ($this->areaId && $this->hasSubareas && $data['parent_id'] != Area::find($this->areaId)->parent_id) {
            session()->flash('error', 'No puedes cambiar el área padre porque esta área contiene subáreas. Elimina o reubica las subáreas primero.');
            return;
        }

        if ($this->areaId) {
            Area::find($this->areaId)->update($data);
            session()->flash('success', 'Área actualizada.');
        } else {
            Area::create($data);
            session()->flash('success', 'Área creada.');
        }

        return redirect()->route('maintenance-areas');
    }

    public function cancel()
    {
        return redirect()->route('maintenance-areas');
    }

    /**
     * Función recursiva para mostrar las áreas en jerarquía.
     * Devuelve un array de ['id' => ..., 'label' => 'Padre > Hijo > Nieto']
     */
    public function getAreasHierarchy($areas = null, $parent = null, $prefix = '')
    {
        $result = [];
        $areas = $areas ?: $this->areasList;
        foreach ($areas as $area) {
            if ($area->parent_id == $parent) {
                $label = $prefix . $area->name;
                $result[] = ['id' => $area->id, 'label' => $label];
                $children = $this->getAreasHierarchy($areas, $area->id, $label . ' > ');
                foreach ($children as $child) {
                    $result[] = $child;
                }
            }
        }
        return $result;
    }

    public function render()
    {
        // Genera la jerarquía de áreas para el combo (excepto el área actual, para evitar loops)
        $areasHierarchy = collect($this->getAreasHierarchy())
            ->filter(fn($a) => $a['id'] != $this->areaId)
            ->all();

        return view('livewire.maintenance.catalogs.areas.form', [
            'areasHierarchy' => $areasHierarchy,
            'hasSubareas'    => $this->hasSubareas,
        ]);
    }
}
