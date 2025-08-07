@props([
    'prefix'=> null,
    'applications'=> [],
    'mode'=>''
])
<form wire:submit.prevent="save">

    <x-select-choices
        prefix="form"
        name="application_id"
        id="application_id"
        label="Apliación"
        :options="$applications"
        placeholder="Selecciona una aplicación"
        :multiple="false"
        :required="true"
        :mode="$mode"
    />

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


