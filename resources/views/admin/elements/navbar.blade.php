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
				  <img class="border-2 brc-white-tp1 radius-round" width="36" src="{{ asset('admin/assets/image/user.jpg') }}" alt="Jason's Photo">
				  <span class="bgc-warning radius-round border-2 brc-white p-1 position-tr mr-1px mt-1px"></span>
			</span>
		</button>

		<div class="navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu">

			<div class="navbar-nav">
				<ul class="nav">

					

					<li class="nav-item dropdown dropdown-mega">
						<a class="nav-link dropdown-toggle pl-lg-3 pr-lg-4" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-bell text-110 icon-animated-bell mr-lg-2"></i>

							<span class="d-inline-block d-lg-none ml-2">Notifications</span>
							<!-- show only on mobile -->
							<span id="id-navbar-badge1" class="badge badge-sm badge-warning radius-round text-80 border-1 brc-white-tp5">3</span>

							<i class="caret fa fa-angle-left d-block d-lg-none"></i>
							<div class="dropdown-caret brc-white"></div>
						</a>
						<div class="shadow dropdown-menu dropdown-animated dropdown-sm p-0 bg-white brc-primary-m3 border-1 border-b-2">
							<ul class="nav nav-tabs nav-tabs-simple w-100 nav-justified dropdown-clickable border-b-1 brc-default-m4">
								<li class="nav-item">
									<a class="d-style px-0 mx-0 py-3 nav-link active text-600 brc-blue-m2 text-grey-m3 bgc-h-blue-l4" data-toggle="tab" href="#navbar-notif-tab-1" role="tab">
										<span class="d-active text-blue-m1 text-105">Notifications</span>
										<span class="d-n-active">Notifications</span>
									</a>
								</li>
								<li class="nav-item">
									<a class="d-style px-0 mx-0 py-3 nav-link text-600 brc-purple-m2 text-grey-m3 bgc-h-purple-l4" data-toggle="tab" href="#navbar-notif-tab-2" role="tab">
										<span class="d-active text-purple-m1 text-105">Messages</span>
										<span class="d-n-active">Messages</span>
									</a>
								</li>
							</ul>
							<!-- .nav-tabs -->

							<div class="tab-content tab-sliding p-0">

								<div class="tab-pane mh-none show active px-md-1 pt-1" id="navbar-notif-tab-1" role="tabpanel">

									<a href="#" class="mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
										<i class="fab fa-twitter bgc-blue-tp1 text-white text-110 mr-1 p-2 radius-1"></i>
										<span class="text-muted">Followers</span>
										<span class="float-right badge badge-danger radius-round text-80">- 4</span>
									</a>
									<a href="#" class="mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
										<i class="fa fa-comment bgc-pink-tp1 text-white text-110 mr-1 p-2 radius-1"></i>
										<span class="text-muted">New Comments</span>
										<span class="float-right badge badge-info radius-round text-80">+12</span>
									</a>
									<a href="#" class="mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
										<i class="fa fa-shopping-cart bgc-success-tp1 text-white text-110 mr-1 p-2 radius-1"></i>
										<span class="text-muted">New Orders</span>
										<span class="float-right badge badge-success radius-round text-80">+8</span>
									</a>
									<a href="#" class="mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
										<i class="far fa-clock bgc-purple-tp1 text-white text-110 mr-1 p-2 radius-1"></i>
										<span class="text-muted">Finished processing data!</span>
									</a>

									<hr class="mt-1 mb-1px brc-info-m4" />
									<a href="#" class="mb-0 py-3 border-0 list-group-item text-blue-m2 text-uppercase text-center text-85 font-bold">
									  See All Notifications
									  <i class="ml-2 fa fa-arrow-right text-muted"></i>
								  </a>

								</div>
								<!-- .tab-pane : notifications -->

								<div class="tab-pane mh-none pl-md-2" id="navbar-notif-tab-2" role="tabpanel">
									<div ace-scroll='{"ignore": "mobile", "height": 300, "smooth":true}'>
										<a href="#" class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
											<img src="{{ asset('admin/assets/image/avatar/avatar.png') }}" width="48" class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round" />
											<div>
												<span class="text-blue-m1 font-bolder">Alex:</span>
												<span class="text-grey text-90">Ciao sociis natoque penatibus et auctor ...</span>
												<br />
												<span class="text-grey-m2 text-85">
												  <i class="far fa-clock"></i>
												  a moment ago
											  </span>
											</div>
										</a>
										<hr class="my-1px brc-grey-l3" />
										<a href="#" class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
											<img src="{{ asset('admin/assets/image/avatar/avatar3.png') }}" width="48" class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round" />
											<div>
												<span class="text-blue-m1 font-bolder">Susan:</span>
												<span class="text-grey text-90">Vestibulum id ligula porta felis euismod ...</span>
												<br />
												<span class="text-grey-m2 text-85">
												  <i class="far fa-clock"></i>
												  20 minutes ago
											  </span>
											</div>
										</a>
										<hr class="my-1px brc-grey-l3" />
										<a href="#" class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
											<img src="{{ asset('admin/assets/image/avatar/avatar4.png') }}" width="48" class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round" />
											<div>
												<span class="text-blue-m1 font-bolder">Bob:</span>
												<span class="text-grey text-90">Nullam quis risus eget urna mollis ornare ...</span>
												<br />
												<span class="text-grey-m2 text-85">
												  <i class="far fa-clock"></i>
												  3:15 pm
											  </span>
											</div>
										</a>
										<hr class="my-1px brc-grey-l3" />
										<a href="#" class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
											<img src="{{ asset('admin/assets/image/avatar/avatar2.png') }}" width="48" class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round" />
											<div>
												<span class="text-blue-m1 font-bolder">Kate:</span>
												<span class="text-grey text-90">Ciao sociis natoque eget urna mollis ornare ...</span>
												<br />
												<span class="text-grey-m2 text-85">
												  <i class="far fa-clock"></i>
												  1:33 pm
											  </span>
											</div>
										</a>
										<hr class="my-1px brc-grey-l3" />
										<a href="#" class="d-flex mb-0 border-0 list-group-item list-group-item-action btn-h-lighter-secondary">
											<img src="{{ asset('admin/assets/image/avatar/avatar5.png') }}" width="48" class="align-self-start border-2 brc-primary-m3 p-1px mr-2 radius-round" />
											<div>
												<span class="text-blue-m1 font-bolder">Fred:</span>
												<span class="text-grey text-90">Vestibulum id penatibus et auctor  ...</span>
												<br />
												<span class="text-grey-m2 text-85">
												  <i class="far fa-clock"></i>
												  10:09 am
											  </span>
											</div>
										</a>

									</div>
									<!-- ace-scroll -->

									<hr class="my-1px brc-grey-l2 border-double" />
									<a href="inbox" class="mb-0 py-3 border-0 list-group-item text-blue-m2 text-uppercase text-center text-85 font-bold">
									  See All Messages
									  <i class="ml-2 fa fa-arrow-right text-muted"></i>
								  </a>
								</div>
								<!-- .tab-pane : messages -->

							</div>
						</div>
					</li>

					<li class="nav-item dd-backdrop dropdown dropdown-mega">
						<a class="nav-link dropdown-toggle pl-lg-3 pr-lg-4" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-flask text-110 icon-animated-vertical mr-lg-1"></i>

							<span class="d-inline-block d-lg-none ml-2">Tasks</span>
							<!-- show only on mobile -->
							<span id="id-navbar-badge2" class="badge badge-sm text-90 text-success-l4">+2</span>

							<i class="caret fa fa-angle-left d-block d-lg-none"></i>
							<div class="dropdown-caret brc-warning-l2"></div>
						</a>
						<div class="shadow dropdown-menu dropdown-animated animated-1 dropdown-xs p-0 bg-white brc-warning-l1 border-x-1 border-b-1">
							<div class="bgc-warning-l2 py-25 px-4 border-b-1 brc-warning-l2">
								<span class="text-dark-tp4 text-600 text-90 text-uppercase">
							  <i class="fa fa-check mr-2px text-warning-d2 text-120"></i>
							  4 Tasks to complete
							</span>
							</div>

							<div class="px-4 py-2">
								<div class="text-95">
									<span class="text-grey-d1">Software update</span>
								</div>
								<div class="progress mt-2">
									<div class="progress-bar bgc-info" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
								</div>
							</div>

							<hr class="my-1 mx-4" />
							<div class="px-4 py-2">
								<div class="text-95">
									<span class="text-grey-d1">Hardware upgrade</span>
								</div>
								<div class="progress mt-2">
									<div class="progress-bar bgc-warning" role="progressbar" style="width: 40%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">40%</div>
								</div>
							</div>

							<hr class="my-1 mx-4" />
							<div class="px-4 py-2">
								<div class="text-95">
									<span class="text-grey-d1">Customer support</span>
								</div>
								<div class="progress mt-2">
									<div class="progress-bar bgc-danger" role="progressbar" style="width: 30%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">30%</div>
								</div>
							</div>

							<hr class="my-1 mx-4" />
							<div class="px-4 py-2">
								<div class="text-95">
									<span class="text-grey-d1">Fixing bugs</span>
								</div>
								<div class="progress mt-2">
									<div class="progress-bar bgc-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 85%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">85%</div>
								</div>
							</div>

							<hr class="my-1px mx-2 brc-info-l2 " />
							<a href="#" class="d-block bgc-h-primary-l4 py-3 border-0 text-center text-blue-m2">
								<span class="text-85 text-600 text-uppercase">See All Tasks</span>
								<i class="ml-2 fa fa-arrow-right text-muted"></i>
							</a>
						</div>
					</li>

					<li class="nav-item dropdown order-first order-lg-last">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
							<img id="id-navbar-user-image" class="d-none d-lg-inline-block radius-round border-2 brc-white-tp1 mr-2" src="{{ asset('admin/assets/image/user.jpg') }}" alt="Jason's Photo">
							<span class="d-inline-block d-lg-none d-xl-inline-block">
							  <span class="text-90" id="id-user-welcome">Welcome,</span>
							<span class="nav-user-name">Jason</span>
							</span>

							<i class="caret fa fa-angle-down d-none d-xl-block"></i>
							<i class="caret fa fa-angle-left d-block d-lg-none"></i>
						</a>

						<div class="dropdown-menu dropdown-caret dropdown-menu-right dropdown-animated brc-primary-m3">
							<div class="d-none d-lg-block d-xl-none">
								<div class="dropdown-header">
									Welcome, Jason
								</div>
								<div class="dropdown-divider"></div>
							</div>

							<a class="dropdown-item btn btn-outline-grey btn-h-lighter-primary btn-a-lighter-primary" href="page-profile">
								<i class="fa fa-user text-primary-m1 text-105 mr-1"></i> Profile
							</a>

							<a class="dropdown-item btn btn-outline-grey btn-h-lighter-success btn-a-lighter-success" href="#" data-toggle="modal" data-target="#id-ace-settings-modal">
								<i class="fa fa-cog text-success-m1 text-105 mr-1"></i> Settings
							</a>

							<div class="dropdown-divider brc-primary-l2"></div>

							<a class="dropdown-item btn btn-outline-grey btn-h-lighter-secondary btn-a-lighter-secondary" href="page-login">
								<i class="fa fa-power-off text-warning-d1 text-105 mr-1"></i> Logout
							</a>
						</div>
					</li>
					<!-- /.nav-item:last -->

				</ul>
				<!-- /.navbar-nav menu -->
			</div>
			<!-- /.navbar-nav -->

		</div>
		<!-- /.navbar-menu.navbar-collapse -->

	</div>
	<!-- /.navbar-inner -->
</nav>