@php
    use App\Helper\Template;
    $controllerVar = Template::setControllerVar($controllerName);
    $imgUrl = $item['thumb'] ? '/images/'.$item['thumb'] : '/admin/assets/image/avatar/avatar.png';
    $roles = Template::showSelectRow($roles,$item['level']);
@endphp
@extends('admin.main')
@section('content')
    <div class="col-12">
       @include('admin.templates.error') 
        <div class="row">
            <div class="col-8">
                <form action="{{ route($controllerName.'/save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-4">
                            <div class="form-group row">
                                <div class="col-12 mb-4">
                                    <input type="file" style="display:none;" id="avatar" name="thumb">
                                    <button id="change-avatar" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt text-white-l1"></i> Change Avatar</button>
                                </div>
                                <div class="col-12">
                                    <img src="{{ $imgUrl }}" width="100%">
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            
                            <div class="form-group row">
                                <div class="col-sm-12 input-floating-label text-blue-d1 brc-blue-m1">
                                    <input type="text" value="{{ $item['email'] }}" class="form-control form-control-md col-sm-12 col-md-12 shadow-none" autocomplete="off" id="post-seodes" name="email">
                                    <span class="floating-label text-grey-m3">Email</span>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-12 input-floating-label text-blue-d1 brc-blue-m1">
                                    <input type="text" value="{{ $item['name'] }}" class="form-control form-control-md col-sm-12 col-md-12 shadow-none" autocomplete="off" id="post-title" name="name">
                                    <span class="floating-label text-grey-m3">Full Name</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 input-floating-label text-blue-d1 brc-blue-m1">
                                    <input type="text" value="{{ $item['phone'] }}" class="form-control form-control-md col-sm-12 col-md-12 shadow-none" autocomplete="off" id="post-seokey" name="phone">
                                    <span class="floating-label text-grey-m3">Phone Number</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 ">
                                    <label for="status"> Status: </label>
                                    <label>
                                        <input type="radio" {{ $item['status'] == 'active'? 'checked': '' }} name="status" value="active" class="text-success">
                                        Active
                                    </label>
                                    <label>
                                        <input type="radio" {{ $item['status'] == 'inactive'? 'checked': '' }} name="status" value="inactive" class="text-danger">
                                        Inactive
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <div class="col-3">
                                    <button class="btn btn-info" type="button" id="upload-thumb" data-toggle="modal" data-target="#modalFullscreen" data-url="{{ route('media/list') }}"><i class="fa fa-image"></i> Add Media</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <textarea id="summernote" name="content">{{ $item['content'] }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <input type="hidden" name="task" value="{{ $task }}">
                                    <input type="hidden" name="old_thumb" value="{{ $item['thumb'] }}">
                                    <button type="submit" class="btn btn-success btn-block">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($controllerName.'/change-password') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-12 input-floating-label text-blue-d1 brc-blue-m1">
                                    <input type="password" class="form-control form-control-md col-sm-12 col-md-12 shadow-none" autocomplete="off" id="post-pass" name="password">
                                    <span class="floating-label text-grey-m3">New Password</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 input-floating-label text-blue-d1 brc-blue-m1">
                                    <input type="password" class="form-control form-control-md col-sm-12 col-md-12 shadow-none" autocomplete="off" id="post-rnpass" name="password_confirmation">
                                    <span class="floating-label text-grey-m3">Re Password</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <input type="hidden" name="task" value="change-password">
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Change Level
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($controllerName.'/level') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                {!! $roles !!}
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="task" value="change-level">
                                <input type="hidden" value="{{ $item['id'] }}" name="id">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    {!! $controllerVar !!}
    <script>
        var tagArr = [];
    </script>
    <script src="{{ asset('admin/js/form.js') }}"></script>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/summernote-lite.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/dropzone.css') }}">
@endsection