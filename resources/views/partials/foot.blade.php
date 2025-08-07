@livewireScripts
<script src="{{ asset('velzon/js/layout.js') }}"></script>
<script src="{{ asset('velzon/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('velzon/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('velzon/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('velzon/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('velzon/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>

<script src="{{ asset('velzon/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('velzon/js/pages/sweetalerts.init.js') }}"></script>

@stack('js')
<script src="{{ asset('velzon/js/app.js') }}"></script>
<!-- password-addon init -->
<script src="{{ asset('velzon/js/pages/password-addon.init.js') }}"></script>

<script>
    @stack('scripts')
</script>
