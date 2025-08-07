@props([
    'prefix'=> null,
    'mode'=>''
])
<form wire:submit.prevent="save">

    <x-input-text
        prefix="form"
        name="name"
        type="text"
        label="Aplicación"
        placeholder="Nombre de la aplicación"
        :required="true"
        :mode="$mode"
    />
</form>


