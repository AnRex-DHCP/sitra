@props([
    'prefix'=> null,
    'applications'=> [],
    'modules'=> [],
    'mode'=>''
])
<form wire:submit.prevent="save">

    <x-input-text
        prefix="form"
        name="name"
        type="text"
        label="Permiso"
        placeholder="Nombre o descripción del permiso"
        :required="true"
        :mode="$mode"
    />


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

    <x-select-choices
        prefix="form"
        name="permission_module_id"
        id="permission_module_id"
        label="Módulo"
        :options="$modules"
        placeholder="Selecciona una módulo"
        :multiple="false"
        :required="true"
        :mode="$mode"
    />


</form>


