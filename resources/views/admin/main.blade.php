<!doctype html>
<html lang="en">

<head>
	@include('admin.elements.head')
	<!-- include common vendor stylesheets -->
	<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/bootstrap/bootstrap.min.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/fontawesome-free/css/fontawesome.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/fontawesome-free/css/regular.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/fontawesome-free/css/brands.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/fontawesome-free/css/solid.css') }}">

	<!-- include vendor stylesheets used in "Dashboard" page. see "application/views/default/pages/partials/dashboard/@vendor-stylesheets.hbs" -->
	@yield('css')

	<link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/ace-font.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('admin/dist/css/ace.css') }}">

	<link rel="icon" type="image/png" href="{{ asset('admin/assets/favicon.png') }}" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
	<div class="body-container">
		@include('admin.elements.navbar')
		<div class="main-container">

			@include('admin.elements.sidebar')
			<!-- /#sidebar -->
			<div role="main" class="main-content">

				<div class="page-content container">
					<div class="page-header">
						<h1 class="page-title text-primary-d2">
							{{ $pageInfo['page-title'] }}
							<small class="page-info text-secondary-d2">
							<i class="fa fa-angle-double-right text-80"></i>
							{{ $pageInfo['page-name'] }}
							</small>
							@if($pageInfo['add'] == 'yes')
							@php
								$link = route($controllerName).'/form';
							@endphp
							<a href="{{ $link }}" class="btn btn-warning">Add New</a>
							@else
							<a href="{{ route($controllerName) }}" class="btn btn-warning"><i class="fa fa-arrow-left text-white-tp2 text-110 mt-3px"></i>  Back To List</a>
							@endif
						</h1>
					</div>
					<div class="row">
						@yield('content')
					</div>
				</div>
				<!-- /.page-content -->

				@include('admin.elements.footer')
			</div>
			<!-- /main -->
		</div>
		<!-- /.main-container -->

		<!-- include common vendor scripts used in demo pages -->
		<script type="text/javascript" src="{{ asset('admin/js/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('admin/js/popper.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('admin/js/bootstrap.min.js') }}"></script>

		<!-- include vendor scripts used in "Dashboard" page. see "application/views/default/pages/partials/dashboard/@vendor-scripts.hbs" -->
		@yield('script')
		<!-- include Ace script -->
		<script type="text/javascript" src="{{ asset('admin/dist/js/ace.js') }}"></script>
		<script type="text/javascript" src="{{ asset('admin/js/custom.js') }}"></script>

		@include('admin.templates.notify')
	</div>
	<!-- /.body-container -->
</body>

</html>