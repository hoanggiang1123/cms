@php
use App\Helper\Template;
    $categories = Template::setActiveCategory($categories,$item['category']);
    $tags = Template::setActiveTag($item['tag']);
    $task = Template::setTask($task);
    $controllerVar = Template::setControllerVar($controllerName);
@endphp
@extends('admin.main')
@section('content')
    <div class="col-12">
       @include('admin.templates.error')
        <form action="{{ route($controllerName.'/save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-8">
                    <div class="form-group row">
                        <div class="col-sm-12 input-floating-label text-blue-d1 brc-blue-m1">
                            <input type="text" value="{{ $item['title']? $item['title']: old('title') }}" class="form-control form-control-md col-sm-12 col-md-12 shadow-none" autocomplete="off" id="post-title" name="title">
                            <span class="floating-label text-grey-m3">Title</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-2 col-form-label">
                            <label for="id-form-field-1" class="mb-0"><strong>Permalink: </strong></label>
                        </div>
                        <div class="col-10">
                            <input type="text" class="form-control" name="slug" id="post-slug" value="{{ $item['slug']? $item['slug']: old('slug') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <button class="btn btn-info" type="button" id="upload-thumb" data-toggle="modal" data-target="#modalFullscreen" data-url="{{ route('media/list') }}"><i class="fa fa-image"></i> Add Media</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <textarea id="summernote" name="content">{{ $item['content']?  $item['content'] : old('content')}}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 input-floating-label text-blue-d1 brc-blue-m1">
                            <input type="text" value="{{ $item['seotitle']? $item['seotitle'] : old('seotitle') }}" class="form-control form-control-md col-sm-12 col-md-12 shadow-none" autocomplete="off" id="post-seotitle" name="seotitle">
                            <span class="floating-label text-grey-m3">Seo Title</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 input-floating-label text-blue-d1 brc-blue-m1">
                            <input type="text" value="{{ $item['seodes']?  $item['seodes']: old('seodes') }}" class="form-control form-control-md col-sm-12 col-md-12 shadow-none" autocomplete="off" id="post-seodes" name="seodes">
                            <span class="floating-label text-grey-m3">Seo Description</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 input-floating-label text-blue-d1 brc-blue-m1">
                            <input type="text" value="{{ $item['seokey']? $item['seokey']: old('seokey') }}" class="form-control form-control-md col-sm-12 col-md-12 shadow-none" autocomplete="off" id="post-seokey" name="seokey">
                            <span class="floating-label text-grey-m3">Seo Keywords</span>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card radius-0 mb-4">
                        <div class="card-header bgc-primary">
                            <h5 class="card-title text-white font-light"><i class="fa fa-table mr-2px"></i> Publish</h5>
                            <div class="card-toolbar">
                                <a href="#" data-action="toggle" class="card-toolbar-btn text-white"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-2 col-form-label">
                                    <label for="status">Status:</label>
                                </div>
                                <div class="col-10">
                                    <select name="status" id="post-status" class="form-control">
                                        @php
                                            $select1 = $item["status"] == "active"? "selected":"";
                                            $select2 = $item['status'] == 'inactive'? 'selected':'';
                                        @endphp
                                        <option value="active" {{ $select1  }}>Active</option>
                                        <option value="inactive"  {{ $select2  }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <span><strong>Created Time:</strong> {{ $item['created'] }} <strong>by:</strong> {{ $item['created_by'] }}</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <span><strong>Modified Time:</strong> {{ $item['modified'] }} <strong>by:</strong> {{ $item['modified_by'] }}</span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="bgc-light px-3 py-2 border-t-1 brc-light d-flex justify-content-between">
                            <input type="hidden" name="id" value="{{ $item['id'] }}">
                            
                            <button type="submit" class="btn btn-bold btn-sm btn-success"><i class="fa fa-check mr-1"></i></i> Publish </button>
                        </div>
                    </div>
                    <div class="card radius-0 mb-4">
                        <div class="card-header bgc-primary">
                            <h5 class="card-title text-white font-light"> Categories </h5>
                            <div class="card-toolbar">
                                <a href="#" data-action="toggle" class="card-toolbar-btn text-white"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="card-body show bg-white px-2 ace-scroll ace-scroll-wrap" ace-scroll="{'height': 250,'smooth':true}" style="max-height: 250px;">
                            <div class="pl-2">
                                @forelse($categories as $cat)
                                
                                <div>
                                    <label>
                                        <input type="checkbox" name="category_name[]" value="{{ $cat['id'] }},{{ $cat['title'] }}" {{ (isset($cat['active']) && $cat['active'] == 'yes')? 'checked': '' }}>
                                        {{ $cat['title'] }}
                                    </label>
                                </div>
                                @empty
                                    <div>
                                        <label for="empty-cat">Pls Create Category</label>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="card radius-0 mb-4">
                        <div class="card-header bgc-primary">
                            <h5 class="card-title text-white font-light"> Tags </h5>
                            <div class="card-toolbar">
                                <a href="#" data-action="toggle" class="card-toolbar-btn text-white"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group form-inline">
                                <input type="hidden" name="tags" id="tags">
                                <input type="text" placeholder="Separate tags with commas" id="inputTag" class="form-control mr-2">
                                <button class="btn-info btn" id="addTag">Add</button>
                            </div>
                            <div class="bootstrap-tagsinput" style="display:none;">
                                
                            </div>
                        </div>
                    </div>
                    <div class="card radius-0 mb-4">
                        <div class="card-header bgc-primary">
                            <h5 class="card-title text-white font-light"> ThumbNail </h5>
                            <div class="card-toolbar">
                                <a href="#" data-action="toggle" class="card-toolbar-btn text-white"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="thumb" value="{{ $item['thumb'] }}">
                            <div class="thumbnail" style="max-height:250px;overflow:hidden;">
                                <img width="100%" src="{{ $item['thumb']? '/images/'.$item['thumb']:'' }}" alt="">
                            </div>
                            <a href="javascript:;" id="feature-thumb" class="btn text-primary" style="display: {{ $item['thumb']? 'none':'block' }}">Set Feature Thumb</a>

                            <a href="javascript:;" id="remove-thumb" class="btn text-danger" style="display: {{ $item['thumb']? 'block':'none' }}">Remove Feature Thumb</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- modal -->
        <div class="modal fade modal-fs" id="modalFullscreen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="padding-bottom:0px;">
                        <ul class="nav nav-tabs page-nav-tabs nav-tabs-scroll is-scrollable mx-n3 mx-lg-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link pl-3 btn-lighter-primary btn-h-lighter-primary btn-a-lighter-primary brc-primary-m1 d-style" id="upload-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="tabs" aria-selected="true">
                                    <i class="text-success-m2 fa fa-upload mr-2 text-110"></i>
                                    Upload
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active btn-lighter-warning btn-h-lighter-warning btn-a-lighter-warning brc-warning-m1 d-style" id="media-tab" data-toggle="tab" href="#media" role="tab" aria-controls="alerts" aria-selected="false">
                                    <i class="text-pink-m3 fas fa-images mr-2 text-110"></i>
                                    Media
                                </a>
                            </li>
                        </ul>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 col-lg-9">
                                <div class="tab-content border-0">
                                    <div class="tab-pane fade show" id="upload">
                                        <div class="row">
                                            <div class="col-12">

                                                <form action="{{ route('media/upload') }}" method="POST" class="dropzone bgc-grey-l3 border-1 brc-grey-l1 radius-1 mt-3 dz-clickable" id="dropzone" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="file" name="file[]" multiple style="display:none" id="files">
                                                    <div class="dz-default dz-message text-center p-5" id="clickUpload">
                                                        <span class="text-150  text-grey-d2">
                                                            <span class="text-130 font-bolder"><i class="fa fa-caret-right text-danger-m1"></i> Drop files</span>
                                                            to upload
                                                            <span class="text-90 text-muted">(or click)</span>
                                                            <br>
                                                            <i class="upload-icon fas fa-cloud-upload-alt text-blue-m2 fa-3x mt-4"></i>
                                                        </span>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade active show" id="media">
                                        <div class="row">
                                            <div class="append-images">
                                                <!-- images -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3 attach-detail" data-edit="{{ route('media/save') }}" data-del="{{ route('media/delete') }}" >
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close-modal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="insert-img"class="btn btn-primary">Insert</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal -->
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('admin/dist/js/sweetalert2.all.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/summernote-lite.js') }}"></script>
    {!! $tags !!}
    {!! $task !!}
    {!! $controllerVar !!}
    <script src="{{ asset('admin/js/form.js') }}"></script>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/summernote-lite.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/dropzone.css') }}">
@endsection