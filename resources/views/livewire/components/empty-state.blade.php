<div class="noresult" style="display: block;">

    <div class="text-center">

        @switch($icon)
            @case('search')
                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                @break
            @case('folder')
                <i class="ri-folder-open-line fs-2 text-muted"></i>
                @break
            @default
                <i class="ri-information-line fs-2 text-muted"></i>
        @endswitch


        <h5 class="mt-2">{{ $title }}</h5>
        <p class="text-muted mb-0">{{ $message }}</p>
    </div>


</div>
