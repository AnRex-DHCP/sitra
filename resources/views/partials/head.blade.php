<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? 'Laravel' }}</title>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<meta charset="utf-8" />
<title>CRM | Livewire</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="CRM | Livewire" name="description" />
<meta content="CRM" name="author" />

<link rel="shortcut icon" href="assets/images/favicon.ico">

<link href="{{ asset('velzon/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('velzon/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('velzon/css/app.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('velzon/css/custom.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('velzon/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"/>
@stack('custom_styles')

@livewireStyles
<style>
    .auth-bg-cover {
        background: linear-gradient(-45deg, #f9f6f6 50%, #ffffff);
    }
</style>
