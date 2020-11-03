@if ($paginator->hasPages())
<div class="paginating-container pagination-solid">
    <ul class="pagination">
        <!-- {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="prev"><a href="javascript:void(0);">Prev</a></li>
        @else
        <li><a href="{{ $paginator->previousPageUrl() }}">Prev</a></li>
        @endif -->

        @foreach($elements as $element)
        {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><a href="javascript:void(0);" wire:click="gotoPage({{ $page }})">{{ $page }}</a></li>
                    @else
                    <li><a href="javascript:void(0);" wire:click="gotoPage({{ $page }})">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        <!-- {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}">Next</a></li>
        @else
        <li class="next"><a href="javascript:void(0);">Next</a></li>
        @endif -->
    </ul>
</div>
@endif
