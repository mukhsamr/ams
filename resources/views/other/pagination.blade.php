@if ($paginator->hasPages())
<nav>
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if (! $paginator->onFirstPage())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->url(1) }}" rel="prev">&laquo;</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a>
        </li>
        @endif

        {{-- Current Page --}}
        <li class="page-item active mx-0" aria-current="page">
            <a class="page-link" rel="current">{{ $paginator->currentPage() }}</a>
        </li>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" rel="next">&raquo;</a>
        </li>
        @endif
    </ul>
</nav>
@endif
