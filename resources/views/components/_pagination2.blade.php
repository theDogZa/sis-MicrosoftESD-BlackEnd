@if ($paginator->hasPages())
    <ul class="pagination" style=" margin-top:0px;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <!-- <li class="disabled"><span>{{ __('pagination.first') }}</span></li>
            <li class="disabled"><span>&laquo; previous</span></li> -->
        @else
          <li><a href="{{ $paginator->url(1) }}" rel="first">{{ __('pagination.first') }}</a></li>
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">{{ __('pagination.previous') }}</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">{{ __('pagination.next') }}</a></li>
            <li><a href="{{ $paginator->url($paginator->lastpage()) }}" rel="last">{{ __('pagination.last') }}</a></li>
        @else
            <!-- <li class="disabled"><span>{{ __('pagination.next') }}</span></li>
            <li class="disabled"><span>{{ __('pagination.last') }}</span></li> -->
        @endif
    </ul>
@endif