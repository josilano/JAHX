<ul class="pagination">
    <li @if (1 == $paginacao->currentPage()) class="disabled" @else class="waves-effect"@endif>
        <a href="{{ $paginacao->previousPageUrl() }}"><i class="material-icons">chevron_left</i></a>
    </li>
    @for ($i = 1; $i <= $paginacao->lastPage(); $i++)
        <li @if ($i == $paginacao->currentPage()) class="active yellow"@else class="waves-effect"@endif>
            <a href="{{ $paginacao->url($i) }}">{{ $i }}</a>
        </li>
    @endfor
    <li @if ($paginacao->lastPage() == $paginacao->currentPage()) class="disabled" @else class="waves-effect"@endif>
        <a href="{{ $paginacao->nextPageUrl() }}"><i class="material-icons">chevron_right</i></a>
    </li>
</ul>