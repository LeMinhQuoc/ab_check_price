@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <!-- Previous Page Link -->
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Trang Trước</a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Trang Trước</a>
                </li>
            @endif

            <!-- Pagination Elements -->
            @foreach($elements as $element)
                <!-- Array Of Links -->
                @if(is_array($element))
                    @foreach($element as $page => $url)
                        @if($page == $paginator->currentPage())
                            <li class="page-item active">
                                <a class="page-link" href="#">{{ $page }} <span class="sr-only">(current)</span></a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <!-- Next Page Link -->
            @if($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Trang tiếp</a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="#">Trang tiếp</a>
                </li>
            @endif

            <!-- Display The Current Page and Total Number of Pages -->


            <!--
            <li class="page-item disabled">
                <a class="page-link" href="#">
                   Đang ở trang {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }} trang
                </a>
            </li> -->
        </ul>
    </nav>
@endif