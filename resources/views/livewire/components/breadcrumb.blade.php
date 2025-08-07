<div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
    <h4 class="mb-sm-0">{{ end($breadcrumbs)['title'] }}</h4>

        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                @foreach($breadcrumbs as $breadcrumb)
                    @if($breadcrumb['title'] !== '')
                        <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active' : '' }}">
                            @if($breadcrumb['active'])
                                {{ $breadcrumb['title'] }}
                            @else
                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ol>
        </div>
</div>
