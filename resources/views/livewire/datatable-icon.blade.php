@if($sortBy != $field)
    <i class="fas fa-arrows-alt-v"></i>
@elseif($sortBy == $field)
    @if($sortDirection == 'asc')
        <i class="fas fa-sort-alpha-up"></i>
    @elseif($sortDirection == 'desc')
        <i class="fas fa-sort-alpha-down-alt"></i>
    @endif
@endif
