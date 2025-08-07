@props([
    'prefix'=> null,
    'mode'=>''
])


    <x-input-text
        prefix="form"
        name="name"
        type="text"
        label="Rol"
        placeholder="Nombre del rol"
        :required="true"
        :mode="$mode"
    />






