<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Button extends Component
{
    public string $text = 'Enviar';
    public string $type = 'button';
    public string $class = 'bg-blue-600 text-white px-4 py-2 rounded';
    public ?string $action = null; // para wire:click
    public ?string $icon = null;
    public ?string $href = null;

    public function render()
    {
        return view('livewire.components.button', [
            'fullClass' => $this->class,
        ]);
    }

}
