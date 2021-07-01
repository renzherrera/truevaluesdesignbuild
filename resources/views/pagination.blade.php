@if ($paginator->hasPages())
<nav>
    <ul class="pagination justify-content-center mb-0">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="page-link" aria-hidden="true"><span>Prev</span></button></span>
            </li>
        @else
            <li class="page-item">
                <button class="page-link" wire:click="previousPage"  dusk="previousPage" wire:loading.attr="disabled" aria-label="@lang('pagination.previous')"> 
                    <i class="fas fa-angle-left"></i>
                    <span>Prev</span></button>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><button class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</button></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <button class="page-link" wire:click="nextPage"  dusk="nextPage" wire:loading.attr="disabled"  aria-label="@lang('pagination.next')"><i class="fas fa-angle-right"></i>
                    <span >Next</span></button>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="page-link" aria-hidden="true"><i class="fas fa-angle-right"></i>
                    <span >Next</span></span>
            </li>
        @endif
    </ul>
</nav>
@endif

