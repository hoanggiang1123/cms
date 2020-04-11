@extends('admin.login')
@section('content')
    @include('admin.templates.error')
    <form class="form-row mt-4" method="POST" action="{{ route($controllerName.'/postLogin') }}">
        @csrf
        <div class="form-group col-md-6 offset-md-3">
            <div class="d-flex align-items-center input-floating-label text-blue-m1 brc-blue-m2">
                <input type="text" class="form-control form-control-lg pr-4 shadow-none" id="id-login-username" autocomplete="off" name="username"/>
                <i class="fa fa-user text-grey-m2 ml-n4"></i>
                <label class="floating-label text-grey-l1 text-100 ml-n3" for="id-login-username">Username</label>
            </div>
        </div>

        <div class="form-group col-md-6 offset-md-3 mt-2 mt-md-1">
            <div class="d-flex align-items-center input-floating-label text-blue-m1 brc-blue-m2">
                <input type="password" class="form-control form-control-lg pr-4 shadow-none" id="id-login-password" autocomplete="off" name="password" />
                <i class="fa fa-key text-grey-m2 ml-n4"></i>
                <label class="floating-label text-grey-l1 text-100 ml-n3" for="id-login-password">Password</label>
            </div>
        </div>
        <div class="col-md-6 offset-md-3 text-right text-md-right mt-n2 mb-2">
            <a href="#" class="text-primary-m2 text-95" data-toggle="tab" data-target="#id-tab-forgot">Forgot Password?</a>
        </div>

        <div class="form-group col-md-6 offset-md-3">
            <label class="d-inline-block mt-3 mb-0 text-secondary-d2">
                <input type="checkbox" class="mr-1" id="id-remember-me" /> Remember me
            </label>
            <button type="submit" class="btn btn-info btn-block btn-md btn-bold mt-2 mb-4">
                Sign In
            </button>
        </div>
    </form>

    <div class="form-row">
        <div class="col-12 col-md-6 offset-md-3 d-flex flex-column align-items-center justify-content-center">

            <hr class="brc-default-m4 mt-0 mb-2 w-100" />

            <div class="p-0 px-md-2 text-dark-tp3 my-3">
                Not a member?
                <a class="text-success-m2 text-600 mx-1" data-toggle="tab" data-target="#id-tab-signup" href="#">Signup now</a>
            </div>

            <hr class="brc-default-m4 w-100 mb-2" />
            <div class="mt-n4 bgc-white-tp2 px-3 py-1 text-default-d1 text-90">Or Get Started Using</div>

            <div class="my-2">
                <button type="button" class="btn btn-bgc-white btn-lighter-primary btn-h-primary btn-a-primary border-2 radius-round btn-lg mx-1">
                    <i class="fab fa-facebook-f text-110"></i>
                </button>

                <button type="button" class="btn btn-bgc-white btn-lighter-blue btn-h-info btn-a-info border-2 radius-round btn-lg px-25 mx-1">
                    <i class="fab fa-twitter text-110"></i>
                </button>

                <button type="button" class="btn btn-bgc-white btn-lighter-red btn-h-red btn-a-red border-2 radius-round btn-lg px-25 mx-1">
                    <i class="fab fa-google text-110"></i>
                </button>
            </div>

        </div>
    </div>
@endsection