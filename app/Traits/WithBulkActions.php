<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

trait WithBulkActions
{
    public $selectedItems = [];
    protected string $errorMessage = 'Error al eliminar el registro';

    #[On('recordDeleted')]
    public function handleDelete($id)
    {
        try {
            DB::beginTransaction();

            $model = $this->getModel();
            $record = $model::findOrFail($id);

            if ($record) {
                $record->delete();
            }

            DB::commit();
            $this->dispatch('refreshTable')->to('components.data-table');

        } catch (\Exception $e) {
            session()->flash('error', $this->errorMessage);
            DB::rollback();
        }
    }

    #[On('selectedItemsChanged')]
    public function handleSelectedItemsChanged($selectedItems)
    {
        $this->selectedItems = $selectedItems;
    }

    public function confirmDeleteMultiple()
    {
        if (empty($this->selectedItems)) {
            $this->dispatch('showAlert', [
                'type' => 'warning',
                'message' => 'Por favor, seleccione al menos un registro para eliminar'
            ]);
            return;
        }
        $this->dispatch('confirmDeleteMultiple');
    }

    #[On('deleteMultiple')]
    public function deleteMultiple()
    {
        try {
            DB::beginTransaction();

            $model = $this->getModel();
            $model::whereIn('id', $this->selectedItems)->delete();

            DB::commit();

            $this->selectedItems = [];
            $this->dispatch('refreshTable')->to('components.data-table');
            $this->dispatch('resetSelection')->to('components.data-table');

        } catch (\Exception $e) {
            session()->flash('error', $this->errorMessage);
            DB::rollback();
        }
    }

    /**
     * Debe ser implementado por la clase que use este trait
     * para especificar el modelo a utilizar
     */
    abstract protected function getModel(): string;

    /**
     * Opcional: Permite personalizar el mensaje de error
     */
    protected function setErrorMessage(string $message): void
    {
        $this->errorMessage = $message;
    }
}
