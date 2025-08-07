<?php

namespace App\Livewire\Components;

use Livewire\Component;

class InputText extends Component
{
    public $name = '';
    public $label = '';
    public $type = 'text';
    public $placeholder = '';
    public $required = false;
    public $prefix = '';
    public $defaultClass = 'form-control';
    public $modelName;

    public function mount(
        $name,
        $label = '',
        $type = 'text',
        $placeholder = '',
        $required = false,
        $prefix = '',
        $defaultClass = 'form-control'
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->prefix = $prefix;
        $this->defaultClass = $defaultClass;
        $this->modelName = $this->prefix ? "{$this->prefix}.{$this->name}" : $this->name;
    }

    public function render()
    {
        return view('livewire.components.input-text');
    }
}
