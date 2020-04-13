@php
	$currentUser = request()->session()->get('userInfo');
	$avatar = $currentUser['thumb'] != null? asset('images/'.$currentUser['thumb']) : asset('admin/assets/image/avatar/avatar4.jpg');
@endphp
<nav class="navbar navbar-expand-lg navbar-fixed navbar-default">
	<div class="navbar-inner">

		<div class="navbar-intro justify-content-xl-between">

			<button type="button" class="btn btn-burger burger-arrowed static collapsed ml-2 d-flex d-xl-none" data-toggle-mobile="sidebar" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle sidebar">
				<span class="bars"></span>
			</button>
			<!-- mobile sidebar toggler button -->

			<a class="navbar-brand text-white" href="#">
				<i class="fa fa-leaf"></i>
				<span>HG</span>
				<span>CMS</span>
			</a>
			<!-- /.navbar-brand -->

			<button type="button" class="btn btn-burger mr-2 d-none d-xl-flex" data-toggle="sidebar" data-target="#sidebar" aria-controls="sidebar" aria-expanded="true" aria-label="Toggle sidebar">
				<span class="bars"></span>
			</button>
			<!-- sidebar toggler button -->

		</div>
		<!-- /.navbar-intro -->

		<div class="navbar-content">

			<button class="navbar-toggler py-2" type="button" data-toggle="collapse" data-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle navbar search">
				<i class="fa fa-search text-white text-90 py-1"></i>
			</button>

			<div class="navbar-content-section collapse navbar-collapse navbar-backdrop" id="navbarSearch">
				<div class="d-flex align-items-center ml-lg-3">
					<i class="fa fa-search text-white mr-n1 d-none d-lg-block"></i>
					<input type="text" class="navbar-search-input px-1 pl-lg-4 ml-lg-n3 w-100 autofocus" placeholder=" SEARCH ..." aria-label="Search" />
				</div>
			</div>

		</div>
		<!-- .navbar-content -->

		<!-- mobile #navbarMenu toggler button -->
		<button class="navbar-toggler ml-1 mr-2 px-1" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navbar menu">
			<span class="pos-rel">
				<img class="border-2 brc-white-tp1 radius-round" width="36" src="{{ $avatar }}" alt="Jason's Photo">
				<span class="bgc-warning radius-round border-2 brc-white p-1 position-tr mr-1px mt-1px"></span>
			</span>
		</button>
		<div class="navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu">
			
			@if($currentUser)
			<div class="navbar-nav">
				<ul class="nav">
					<li class="nav-item dropdown order-first order-lg-last">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
							<img id="id-navbar-user-image" class="d-none d-lg-inline-block radius-round border-2 brc-white-tp1 mr-2" src="{{ $avatar }}" alt="Jason's Photo" width="36px" height="36px">
							<span class="d-inline-block d-lg-none d-xl-inline-block">
							  <span class="text-90" id="id-user-welcome">Welcome,</span>
							<span class="nav-user-name">{{ $currentUser->name }}</span>
							</span>

							<i class="caret fa fa-angle-down d-none d-xl-block"></i>
							<i class="caret fa fa-angle-left d-block d-lg-none"></i>
						</a>

						<div class="dropdown-menu dropdown-caret dropdown-menu-right dropdown-animated brc-primary-m3">
							<div class="d-none d-lg-block d-xl-none">
								<div class="dropdown-header">
									Welcome, {{ $currentUser->name }}
								</div>
								<div class="dropdown-divider"></div>
							</div>

							<a class="dropdown-item btn btn-outline-grey btn-h-lighter-primary btn-a-lighter-primary" href="javascript:;">
								<i class="fa fa-user text-primary-m1 text-105 mr-1"></i> Profile
							</a>

							<a class="dropdown-item btn btn-outline-grey btn-h-lighter-success btn-a-lighter-success" href="javascript:;" data-toggle="modal" data-target="#id-ace-settings-modal">
								<i class="fa fa-cog text-success-m1 text-105 mr-1"></i> Settings
							</a>

							<div class="dropdown-divider brc-primary-l2"></div>

							<a class="dropdown-item btn btn-outline-grey btn-h-lighter-secondary btn-a-lighter-secondary" href="{{ route('auth/logout') }}">
								<i class="fa fa-power-off text-warning-d1 text-105 mr-1"></i> Logout
							</a>
						</div>
					</li>
					<!-- /.nav-item:last -->

				</ul>
				<!-- /.navbar-nav menu -->
			</div>
			@endif
			<!-- /.navbar-nav -->

		</div>
		<!-- /.navbar-menu.navbar-collapse -->

	</div>
	<!-- /.navbar-inner -->
</nav>