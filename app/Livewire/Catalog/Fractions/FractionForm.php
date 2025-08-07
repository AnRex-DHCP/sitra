<?php

namespace App\Livewire\Catalog\Fractions;

use Livewire\Component;
use App\Models\Fraction;
use App\Models\Article;
use Illuminate\Validation\Rule;

class FractionForm extends Component
{
    public $fractionId;
    public $article_id;
    public $code;
    public $description;
    public $mode = 'create'; // 'create', 'edit' o 'show'
    public $articlesList;

    public function mount($id = null, $mode = null)
    {
        // 1) Cargamos lista de Artículos para el <select>
        $this->articlesList = Article::orderBy('number')->get();

        // 2) Si nos pasan modo (show/edit)
        if ($mode) {
            $this->mode = $mode;
        }

        // 3) Si tenemos un ID, precargamos para edit/show
        if ($id) {
            $this->fractionId = $id;
            $fraction = Fraction::findOrFail($id);
            $this->article_id  = $fraction->article_id;
            $this->code        = $fraction->code;
            $this->description = $fraction->description;
        }
    }

    protected function rules()
    {
        return [
            'article_id' => ['required', 'exists:articles,id'],
            'code'       => [
                'required',
                'string',
                'max:10',
                // Unique en tabla articles sobre columna number,
                // ignorando el registro actual en edición
                Rule::unique('fractions', 'code')
                    ->ignore($this->fractionId)
                    ->where(fn($q) => $q->where('article_id', $this->article_id)),
            ],
            'description'=> ['nullable', 'string', 'max:255'],
        ];
    }

    protected function messages()
    {
        return [
            'article_id.required'      => 'Debes seleccionar un artículo.',
            'article_id.exists'        => 'El artículo seleccionado no es válido.',
            'code.required'            => 'El código de la fracción es obligatorio.',
            'code.max'                 => 'El código no puede tener más de 10 caracteres.',
            'code.unique'              => 'Ya existe esa fracción (mismo código) para este artículo.',
            'description.max'          => 'La descripción no puede exceder 255 caracteres.',
        ];
    }

    public function save()
    {
        if ($this->mode === 'show') {
            return;
        }

        $data = $this->validate();

        if ($this->fractionId) {
            Fraction::find($this->fractionId)->update($data);
            session()->flash('success', 'Fracción actualizada.');
        } else {
            Fraction::create($data);
            session()->flash('success', 'Fracción creada.');
        }

        return redirect()->route('fractions.index');
    }

    public function cancel()
    {
        return redirect()->route('fractions.index');
    }

    public function render()
    {
        return view('livewire.catalog.fractions.form');
    }
}
