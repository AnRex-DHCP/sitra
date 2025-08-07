<div class="flex flex-col gap-6">


    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <div>
        <h5 class="text-primary">Bienvenid@!</h5>
        <p class="text-muted">Ingresa tu usuario y contraseña para continuar.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-label-icon rounded-label border-0" role="alert">
            <i class="ri-error-warning-line label-icon"></i> <strong> Ha ocurrido un error! </strong>

        </div>
        <ul>
            @foreach($errors->all() as $error)
                <li class="text-danger">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="mt-4">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <x-forms.auth.login></x-forms.auth.login>

            <div class="mt-4">
                <x-buttons.login
                    text="Ingresar"
                    class="w-100"
                ></x-buttons.login>
            </div>

        </form>
    </div>


    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>
