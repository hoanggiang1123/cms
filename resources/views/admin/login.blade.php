<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <base href="/" />

    <title>Login - HGCMS</title>

    <!-- include common vendor stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/bootstrap/bootstrap.min.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/fontawesome-free/css/fontawesome.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/fontawesome-free/css/regular.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/fontawesome-free/css/brands.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/fontawesome-free/css/solid.css') }}">


    <!-- include vendor stylesheets used in "Login" page. see "application/views/default/pages/partials/page-login/@vendor-stylesheets.hbs" -->

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/ace-font.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/ace.css') }}">

    <link rel="icon" type="image/png" href="{{ asset('admin/assets/favicon.png') }}" />
    <style>
        .body-container {
            background-image: linear-gradient(#6baace, #264783);
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .carousel-item > div {
            height: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            }

            /* these make sure in mobile devices, tab panes are not the same height (for example 'forgot' pane is not as tall as 'signup' page) */
        @media (max-width: 767.98px) {
            .tab-sliding .tab-pane:not(.active) {
                max-height: 0 !important;
            }
            .tab-sliding .tab-pane.active {
                min-height: 90vh;
                max-height: none !important;
            }
        }
    </style>
   
</head>

<body>
    <div class="body-container">

        <div class="main-container container">

            <div role="main" class="main-content minh-100 justify-content-center">
                <div class="p-2 p-md-4">
                    <div class="row justify-content-center">
                        <div class="shadow radius-1 overflow-hidden bg-white col-12 col-lg-5">

                            <div class="row">
                                <div class="col-12 py-lg-5 bgc-white px-0">

                                    <div class="tab-content tab-sliding border-0 p-0" data-swipe="right">

                                        <div class="tab-pane active show mh-100 px-3 px-lg-0 pb-3" id="id-tab-login">
                                            <div class="d-none d-lg-block col-md-6 offset-md-3 mt-lg-4 px-0">
                                                <h4 class="text-dark-tp4 border-b-1 brc-grey-l1 pb-1 text-130">
                                                    <i class="fa fa-coffee text-orange-m2 mr-1"></i> Welcome Back
                                                </h4>
                                            </div>

                                            <div class="d-lg-none text-secondary-m1 my-4 text-center">
                                                <a href="html/dashboard.html"><i class="fa fa-leaf text-success-m2 text-200 mb-4"></i></a>
                                                <h1 class="text-170">
                                                    <span class="text-blue-d1">HGCMS <span class="text-80 text-dark-tp3">Application</span></span>
                                                </h1> Welcome back
                                            </div>

                                            @yield('content')
                                        </div>
                                    </div>
                                    <!-- .tab-content -->
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="d-lg-none my-3 text-white-tp1 text-center">
                        <i class="fa fa-leaf text-success-l3 mr-1 text-110"></i> HGCMS &copy; 2019
                    </div>
                </div>
            </div>
            <!-- /main -->

        </div>
        <!-- /.main-container -->

        <!-- include common vendor scripts used in demo pages -->
        <script type="text/javascript" src="{{ asset('admin/js/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('admin/js/popper.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
        <!-- include Ace script -->
		<script type="text/javascript" src="{{ asset('admin/dist/js/ace.js') }}"></script>
       
    </div>
    <!-- /.body-container -->
</body>

</html>