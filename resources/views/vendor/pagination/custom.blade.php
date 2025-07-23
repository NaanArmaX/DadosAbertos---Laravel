@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Botão Anterior --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>← Anterior</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">← Anterior</a></li>
        @endif

        {{-- Botão Próximo --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">Próximo →</a></li>
        @else
            <li class="disabled"><span>Próximo →</span></li>
        @endif
    </ul>
@endif
