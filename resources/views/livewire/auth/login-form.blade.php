<div class="flex flex-col gap-6">


{{--    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />--}}

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


        </form>
    </div>


</div>

