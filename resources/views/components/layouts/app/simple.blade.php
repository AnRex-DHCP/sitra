<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      data-layout="vertical" data-topbar="light" data-sidebar="dark"
      data-sidebar-size="lg" data-sidebar-image="none"
      data-preloader="disable" data-theme="default"
      data-theme-colors="default">

<head>
    @include('partials.head')
    @livewireStyles
</head>

<body>
    <div id="layout-wrapper">
        @include('partials.header')
        @include('partials.sidebar')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @livewire('components.breadcrumb')
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    {{-- Este partial ya existe en tu proyecto --}}
    @include('partials.foot')

    @livewireScripts
    @stack('js')
    @stack('scripts')
</body>
</html>
