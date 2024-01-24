
@if(!$paginator->onFirstPage())
    <a href="{{ $paginator->previousPageUrl() }}" class="previous-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="17" viewBox="0 0 11 17" fill="none">
            <path d="M9.5 1L2 8.5L9.5 16" stroke="#000" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </a>
@else
    <button class="previous-button" disabled>
        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="17" viewBox="0 0 11 17" fill="none">
            <path d="M9.5 1L2 8.5L9.5 16" stroke="#000" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>
@endif
@if($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="next-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="17" viewBox="0 0 11 17" fill="none">
            <path d="M1.5 1L9 8.5L1.5 16" stroke="#000" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </a>
@else
    <button class="next-button" disabled>
        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="17" viewBox="0 0 11 17" fill="none">
            <path d="M1.5 1L9 8.5L1.5 16" stroke="#000" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </button>
@endif

