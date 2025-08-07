<?php

namespace App\Livewire\Catalog\Articles;

use Livewire\Component;
use App\Models\Article;
use Illuminate\Validation\Rule;

class ArticleForm extends Component
{
    public $articleId;
    public $number;
    public $title;
    public $mode = 'create'; // 'create', 'edit' o 'show'

    public function mount($id = null, $mode = null)
    {
        // Si se inyecta mode ('edit' o 'show'), lo guardamos
        if ($mode) {
            $this->mode = $mode;
        }

        // Si llega un $id, cargamos el artículo para editar/mostrar
        if ($id) {
            $this->articleId = $id;
            $article = Article::findOrFail($id);
            $this->number = $article->number;
            $this->title  = $article->title;
        }
    }

    protected function rules()
    {
        return [
            'number' => [
                'required',
                'string',
                'max:40',
                // Unique en tabla articles sobre columna number,
                // ignorando el registro actual en edición
                Rule::unique('articles', 'number')
                    ->ignore($this->articleId),
            ],
            'title' => ['required', 'string', 'max:255'],
        ];
    }

    protected function messages()
    {
        return [
            'number.required' => 'El número es obligatorio.',
            'number.max'      => 'El número no puede exceder 40 caracteres.',
            'number.unique'   => 'El número de artículo ya existe.',
            'title.required'  => 'El título es obligatorio.',
            'title.max'       => 'El título no puede exceder 255 caracteres.',
        ];
    }

    public function save()
    {
        // Si estamos en modo "show", no guardamos
        if ($this->mode === 'show') {
            return;
        }

        $data = $this->validate();

        if ($this->articleId) {
            // Actualizar
            Article::find($this->articleId)->update($data);
            session()->flash('success', 'Artículo actualizado');
        } else {
            // Crear nuevo
            Article::create($data);
            session()->flash('success', 'Artículo creado');
        }

        return redirect()->route('articles.index');
    }

    public function cancel()
    {
        return redirect()->route('articles.index');
    }

    public function render()
    {
        return view('livewire.catalog.articles.form');
    }
}
