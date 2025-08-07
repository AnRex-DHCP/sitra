<div id="scrollbar">
    <div class="container-fluid">

        <div id="two-column-menu">
        </div>

        <ul class="navbar-nav" id="navbar-nav">

            <li class="menu-title"><span data-key="t-menu">Menú</span></li>
            @foreach ($menuItems as $item)
                @php
                    $isActive = request()->routeIs($item['route']) ||
                                (isset($item['children']) && collect($item['children'])->pluck('route')->contains(fn($r) => request()->routeIs($r)));
                    $isParent= !empty($item['children']);
                @endphp

                <li class="nav-item">
                    <a
                        href="{{ ($isParent) ? '#'.$item['label'] : route($item['route']) }}"
                       class="nav-link menu-link
                       {{ $isActive ? 'active ' : '' }}"
                        @if($isParent) data-bs-toggle="collapse" role="button" @endif
                    >
                        <i class="ri-{{ $item['icon'] }}"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>


                    @if ($isParent)
                        <div class="collapse menu-dropdown  @if($isActive) show @endif" id="{{ $item['label'] }}">
                            <ul class="nav nav-sm flex-column">
                                @foreach ($item['children'] as $child)
                                    <li class="nav-item">
                                        <a href="{{ route($child['route']) }}"
                                           class="nav-link
                                            {{ request()->routeIs($child['route']) ? 'active' : '' }}">
                                            {{ $child['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                </li>
            @endforeach


        </ul>
    </div>
    <!-- Sidebar -->
</div>
