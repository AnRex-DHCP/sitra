<?php

namespace App\Livewire\Components;

use Livewire\Component;

class EmptyState extends Component
{
    public string $title;
    public string $message;
    public string $icon;

    public function __construct(
        string $title = '¡Lo siento! No se encontraron resultados. ',
        string $message = 'Hemos buscado en todos los registros y no encontramos ninguna coincidencia para su búsqueda.',
        string $icon = 'search'
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('livewire.components.empty-state');
    }
}
