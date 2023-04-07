@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                            rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div>
                <p class="small text-muted">
                    {!! __('Menampilkan') !!}
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    {!! __('sampai') !!}
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    {!! __('dari') !!}
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    {!! __('hasil') !!}
                </p>
            </div>

            <div>
                @if ($paginator->hasPages())
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($paginator->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">«</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                                    rel="prev">«</a></li>
                        @endif

                        @if ($paginator->currentPage() > 2)
                            <li class="page-item hidden-xs"><a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                            </li>
                        @endif
                        @if ($paginator->currentPage() > 3)
                            <li class="page-item"><span class="page-link">...</span></li>
                        @endif
                        @foreach (range(1, $paginator->lastPage()) as $i)
                            @if ($i >= $paginator->currentPage() - 1 && $i <= $paginator->currentPage() + 1)
                                @if ($i == $paginator->currentPage())
                                    <li class="active bg-primary"><span class="page-link">{{ $i }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                                @endif
                            @endif
                        @endforeach
                        @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                            <li class="page-item"><span class="page-link">...</span></li>
                        @endif
                        @if ($paginator->currentPage() < $paginator->lastPage() - 1)
                            <li class="page-item hidden-xs"><a class="page-link"
                                    href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}"
                                    rel="next">»</a></li>
                        @else
                            <li class="disabled"><span class="page-link">»</span></li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>
    </nav>
@endif
