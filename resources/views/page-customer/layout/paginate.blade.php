@if ($paginator->hasPages())
    <ul class="pagination justify-content-center pagination-one direction-rtl">
        {{-- pre --}}
        @if ($paginator->lastPage() < 8 || $paginator->currentPage() < 4)
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                        <svg class="bi bi-chevron-left" width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z">
                            </path>
                        </svg>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <svg class="bi bi-chevron-left" width="16" height="16" viewBox="0 0 16 16"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z">
                            </path>
                        </svg>
                    </a>
                </li>
            @endif
        @endif

        <?php
        $start = $paginator->currentPage() - 2; // show 3 pagination links before current
        $end = $paginator->currentPage() + 2; // show 3 pagination links after current
        if ($start < 1) {
            $start = 1; // reset start to 1
            $end += 1;
        }
        if ($end >= $paginator->lastPage()) {
            $end = $paginator->lastPage();
        } // reset end to last page
        ?>

        @if ($start > 1)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}">{{ 1 }}</a>
            </li>
            @if ($paginator->currentPage() != 4)
                {{-- "Three Dots" Separator --}}
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
            @endif
        @endif
        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ $paginator->currentPage() == $i ? ' active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        @if ($end < $paginator->lastPage())
            @if ($paginator->currentPage() + 3 != $paginator->lastPage())
                {{-- "Three Dots" Separator --}}
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
            @endif
            <li class="page-item">
                <a class="page-link"
                    href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
            </li>
        @endif

        @if ($paginator->lastPage() < 8 || $paginator->currentPage() < 4)

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link disabled" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <svg class="bi bi-chevron-right" width="16" height="16" viewBox="0 0 16 16"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
                            </path>
                        </svg>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Next">
                        <svg class="bi bi-chevron-right" width="16" height="16" viewBox="0 0 16 16"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z">
                            </path>
                        </svg>
                    </a>
                </li>
            @endif
        @endif
    </ul>
@endif
