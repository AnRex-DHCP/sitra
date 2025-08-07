<?php

namespace App\Livewire\Catalog\Fractions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Fraction;

class FractionIndex extends Component
{
    use WithPagination;

    protected $listeners = [
        'recordDeleted' => 'delete',
    ];

    public function delete($id)
    {
        Fraction::findOrFail($id)->delete();
        $this->dispatch('refreshTable');
    }

    public function render()
    {
        $query = Fraction::with('article')->orderBy('code');

        return view('livewire.catalog.fractions.index', compact('query'));
    }
}