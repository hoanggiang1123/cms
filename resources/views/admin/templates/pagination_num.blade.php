@if ($paginator->hasPages())
<ul class="pagination" style="float:right;">
    @if ($paginator->onFirstPage())
        <li class="paginate_button page-item previous disabled" id="datatable_previous"><a href="javascript:;" aria-controls="datatable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
    @else
        <li class="paginate_button page-item previous" id="datatable_previous"><a href="{{ $paginator->previousPageUrl() }}" aria-controls="datatable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>
    @endif
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <li class="paginate_button page-item ">{{ $element }}</li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="paginate_button page-item active"><a href="javascript:;" aria-controls="datatable" data-dt-idx="1" tabindex="0" class="page-link">{{ $page }}</a></li>
                @else
                    <li class="paginate_button page-item "><a href="{{ $url }}" aria-controls="datatable" data-dt-idx="2" tabindex="0" class="page-link">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <li class="paginate_button page-item next" id="datatable_next"><a href="{{ $paginator->nextPageUrl() }}" aria-controls="datatable" data-dt-idx="3" tabindex="0" class="page-link">Next</a></li>
    @else
        <li class="paginate_button page-item next disabled" id="datatable_next"><a href="javascript:;" aria-controls="datatable" data-dt-idx="3" tabindex="0" class="page-link">Next</a></li>
    @endif
    
</ul>

@endif