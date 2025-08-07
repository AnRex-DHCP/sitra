<?php

namespace App\Livewire\Catalog\Articles;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Article;

class ArticleIndex extends Component
{
    use WithPagination;

    // Escucha el evento que lanza el data-table al borrar
    protected $listeners = [
        'recordDeleted' => 'delete',
    ];

    public function delete($id)
    {
        Article::findOrFail($id)->delete();

        // 2) notifica para que DataTable se refresque
        $this->dispatch('refreshTable');

    }

    public function render()
    {
        $query = Article::query()->orderBy('number');

        return view('livewire.catalog.articles.index', compact('query'));
    }
}
