@extends('admin.main')
@php
    use App\Helper\Template;
    $statusFilter = Template::showStatusFilters($controllerName,$params,$statusFilters);
    $searchFilter = Template::showSearchFilters($controllerName,$params);
    //$categoryFilter = Template::showTerms($controllerName,$params,$terms['category'],'filter_category');
    //$tagFilter = Template::showTerms($controllerName, $params,$terms['tag'],'filter_tag');
    $categoryFilter = Template::showTermsFilter($terms['category'],$params,'filter_category');
    $tagFilter = Template::showTermsFilter($terms['tag'],$params,'filter_tag');
    $bulkAction = Template::showBulkAction($controllerName);
@endphp
@section('content')
    <div class="col-12">
        <div class="row mb-3">
            <div class="col-6">{!! $statusFilter !!}</div>
            <div class="col-6"> {!! $searchFilter !!}</div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group form-inline">
                    {!! $bulkAction !!}
                    <button id="bulk" class="btn btn-primary mb-2px ml-2" disabled>Apply</button>
                </div>
            </div>
            <div class="col-9">
                <div class="form-group form-inline">
                    {!! $categoryFilter !!}
                    {!! $tagFilter !!}
                    <button class="btn btn-primary mb-2px ml-2 filter-term">Filter</button>
                </div>

            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <form action="" method="POST" id="form-tbl">
                    @csrf
                    <table id="simple-table" class="table table-bordered table-bordered-x table-hover text-dark-m2">
                        <thead class="text-dark-m3 bgc-grey-l4">
                            @include('admin.templates.tblhead', ['fields' => ['ID','Title','Thumb','Categories','Tags','Status','Created','Modified', 'Action']])
                        </thead>
                                                
                        <tbody>
                            @forelse($items as $key => $value)
                            @php
                                $thumb = Template::showImage($controllerName, $value['thumb'], $value['title']);
                                $categoryArr = $value['category'] == ''? []:json_decode($value['category'],true);
                                $tagArr =  $value['tag'] == ''? []:json_decode($value['tag'],true);
                                $categories = Template::showTaxonomies('category',$categoryArr);
                                $tags = Template::showTaxonomies('tag',$tagArr);
                                $status = Template::showStatus($controllerName,$value['status'],$value['id']);
                                $created = Template::showHistory($value['created'],$value['created_by']);
                                $modified = Template::showHistory($value['modified'],$value['modified_by']);
                                $action = Template::showAction($controllerName,$value['id']);
                            @endphp
                            <tr class="bgc-h-default-l3 d-style">
                                <td class="text-center pr-0 pos-rel">
                                    <div class="position-tl h-100 ml-n1px border-l-4 brc-info-m1 v-hover"></div>
                                    <div class="position-tl h-100 ml-n1px border-l-4 brc-success-m1 v-active"></div>
                                    <label>
                                        <input type="checkbox" name="cball[]" value="{{ $value['id'] }}" class="align-middle cbsingle" autocomplete="off">
                                    </label>
                                </td>
                                <td class="text-center pr-0">{{ $value['id'] }}</td>
                                <td width="25%"><a href="{{ route($controllerName.'/form',['id'=> $value['id']]) }}" class="text-blue-d2"> {{ $value['title'] }} </a></td>
                                <td>{!! $thumb !!}</td>
                                <td class="d-none d-sm-table-cell">{!! $categories !!}</td>
                                <td class="d-none d-sm-table-cell">{!! $tags !!}</td>
                                <td class="d-none d-sm-table-cell">{!! $status !!}</td>
                                <td>{!! $created !!}</td>
                                <td>{!! $modified !!}</td>
                                <td width="10%">{!! $action !!}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center pr-0"> Data is Updating...</td>
                            </tr>
                            @endforelse

                        </tbody>

                        <tfoot class="text-dark-m3 bgc-grey-l4">
                            @include('admin.templates.tblhead', ['fields' => ['ID','Title','Thumb','Categories','Tags','Status','Created','Modified', 'Action']])
                        </tfoot>
                    </table>
                </form>
                @include('admin.templates.pagination')
            </div>
            
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('admin/dist/js/sweetalert2.all.js') }}"></script>
@endsection