<div class="panel" style="float: right">
  <nav></nav>
  <nav aria-label="Page navigation">

    @if ($paginator->hasPages())
    <ul class="pagination mt-3">

      @if ($paginator->onFirstPage())
      <li class="page-item disabled">
        <a class="page-link disabled" href="#!" aria-label="Previous">
          <span aria-hidden="true">« Prev</span>
        </a>
      </li>
      @else
      <li class="page-item">
        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
          <span aria-hidden="true">« Prev</span>
        </a>
      </li>
      @endif



      @foreach ($elements as $element)

      @if (is_string($element))
      <li class="page-item">{{ $element }}</li>
      @endif



      @if (is_array($element))
      @foreach ($element as $page => $url)
      @if ($page == $paginator->currentPage())
      <li class="page-item disabled active"><a class="page-link" href="#!">{{ $page }}</a></li>
      @else
      <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
      @endif
      @endforeach
      @endif
      @endforeach



      @if ($paginator->hasMorePages())
      <li class="page-item">
        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
          <span aria-hidden="true">Next »</span>
        </a>
      </li>
      @else
      <li class="page-item disabled">
        <a class="page-link" href="#!" aria-label="Next">
          <span aria-hidden="true">Next »</span>
        </a>
      </li>
      @endif
    </ul>
    @endif
  </nav>
</div>