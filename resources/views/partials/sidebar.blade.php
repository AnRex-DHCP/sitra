<div class="app-menu navbar-menu">

    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
        <span class="logo-sm">
            <img src="{{ asset('velzon/images/logo-sm.png') }}" alt="" height="25">
        </span>
            <span class="logo-lg">
            <img src="{{ asset('velzon/images/logo-dark.png') }}" alt="" height="25">
        </span>
        </a>

        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
        <span class="logo-sm">
            <img src="{{ asset('velzon/images/logo-sm.png') }}" alt="" height="25">
        </span>
            <span class="logo-lg">
            <img src="{{ asset('velzon/images/logo-light.png') }}" alt="" height="25">
        </span>
        </a>

        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <livewire:components.sidebar />

    <div class="sidebar-background"></div>

</div>
