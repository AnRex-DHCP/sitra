<!-- resources/views/livewire/auth/login.blade.php -->
<form wire:submit="login">
    <x-input-text
        name="email"
        type="email"
        label="Correo electrónico"
        placeholder="Ingresa tu correo electrónico"
        :required="true"
    />

    <x-input-text
        name="password"
        type="password"
        label="Contraseña"
        placeholder="Ingresa tu contraseña"
        :required="true"
    />

{{--
    <livewire:components.input-text
        :name="'email'"
        type="email"

        :label="'Correo electrónico'"
        :placeholder="'Ingresa tu correo electrónico'"
        :required="true"
    />

    <livewire:components.input-text
        :name="'password'"
        :label="'Contraseña'"
        type="password"
        :placeholder="'Ingresa tu contraseña'"
        :required="true"
    />
--}}

    <livewire:components.button
        :text="'Ingresar'"
        :icon="'ri-lock-unlock-fill'"
        :type="'submit'"
        :class="'mt-3 w-100'"
    />
</form>
