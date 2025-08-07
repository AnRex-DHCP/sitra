<div>
@if ($paginator->hasPages())
    <div class="d-flex justify-content-end mt-3">
        <div class="pagination-wrap hstack gap-2">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="page-item pagination-prev disabled">
                    {!! __('pagination.previous') !!}
                </button>
            @else
                <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="page-item pagination-prev">
                    {!! __('pagination.previous') !!}
                </button>
            @endif

            <ul class="pagination listjs-pagination mb-0">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li>
                            <button disabled class="page disabled">
                                {{ $element }}
                            </button>
                        </li>

                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active">
                                    <button disabled wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled" rel="prev" class="page disabled">
                                        {{ $page }}
                                    </button>
                                </li>
                            @else
                                <li>
                                    <button wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled" rel="prev" class="page">
                                        {{ $page }}
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach


            </ul>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="page-item pagination-next">
                    {!! __('pagination.next') !!}
                </button>
            @else
                <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="page-item pagination-next disabled">
                    {!! __('pagination.next') !!}
                </button>
            @endif


        </div>
    </div>

    @endif
    </div>
