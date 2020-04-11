@php
    $to = $items->currentPage() * $params['pagination']['totalItemsPerPage'];
    $from = ($to - $params['pagination']['totalItemsPerPage']) + 1;
    if($to > $items->total()) $to = $items->total();
@endphp
<div class="row">
    <div class="col-12 col-md-5">
        <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing {{ $from }} to {{ $to }} of {{$items->total()}} entries</div>
    </div>
    <div class="col-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
            {!! $items->appends(request()->input())->links('admin.templates.pagination_num') !!}
        </div>
    </div>
</div>