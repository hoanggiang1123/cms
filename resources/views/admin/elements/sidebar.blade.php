@php
$name = Route::currentRouteName();
@endphp
<div id="sidebar" class="sidebar sidebar-fixed expandable sidebar-default d-none d-xl-block">
	 <div class="sidebar-inner">
			<div class="ace-scroll flex-grow-1" ace-scroll>
				 <div class="sidebar-section my-2">
						<div class="sidebar-section-item fadeable-left">
							 <div class="fadeinable sidebar-shortcuts-mini">
									<span class="btn btn-success p-0"></span>
									<span class="btn btn-info p-0"></span>
									<span class="btn btn-warning p-0"></span>
									<span class="btn btn-danger p-0"></span>
							 </div>
							 <div class="fadeable">
									<div class="sub-arrow"></div>
									<div>
										 <button class="btn btn-smd btn-success">
										 <i class="fa fa-signal"></i>
										 </button>
										 <button class="btn btn-smd btn-info">
										 <i class="fa fa-edit"></i>
										 </button>
										 <button class="btn btn-smd btn-warning">
										 <i class="fa fa-users"></i>
										 </button>
										 <button class="btn btn-smd btn-danger">
										 <i class="fa fa-cogs"></i>
										 </button>
									</div>
							 </div>
						</div>
				 </div>
				 <ul class="nav has-active-border" role="navigation" aria-label="Main">
						<li class="nav-item-caption">
							 <span class="fadeable pl-3">MAIN</span>
							 <span class="fadeinable mt-n2 text-125">&hellip;</span>
						</li>
						<li class="nav-item {{ $controllerName == 'dashboard'? 'active':'' }}">
							 <a href="{{ route('dashboard') }}" class="nav-link">
									<i class="nav-icon fa fa-tachometer-alt"></i>
									<span class="nav-text fadeable">
									<span>Dashboard</span>
									</span>
									<!--
										 -->
							 </a>
							 <b class="sub-arrow"></b>
						</li>
						<li class="nav-item {{ ($controllerName == 'post' || $controllerName == 'category' || $controllerName == 'tag')? 'active':'' }}">
							 <a href="javascript:;" class="nav-link dropdown-toggle">
									<i class="nav-icon fa fa-edit"></i>
									<span class="nav-text fadeable">
									<span>Post Management</span>
									</span>
									<b class="caret fa fa-angle-left rt-n90"></b>
									<!--
										 <b class="caret caret-shown fa fa-minus text-80"></b>
										 <b class="caret caret-hidden fa fa-plus text-80"></b>
										 -->
							 </a>
							 <div class="hideable submenu collapse {{ ($controllerName == 'post' || $controllerName == 'category' || $controllerName == 'tag')? 'show':'' }}">
									<ul class="submenu-inner">
										<li class="nav-item {{ $name == 'post/form'? 'active': '' }}">
											<a href="{{ route('post/form') }}" class="nav-link">
												<span class="nav-text">
												<span>Add Post</span>
												</span>
											</a>
										 </li>
										 <li class="nav-item {{  $name == 'post'? 'active': '' }}">
											<a href="{{ route('post') }}" class="nav-link">
												<span class="nav-text">
												<span>Posts</span>
												</span>
											</a>
										 </li>
										 <li class="nav-item {{  $name == 'category'? 'active': '' }}">
											<a href="{{ route('category') }}" class="nav-link">
												<span class="nav-text">
												<span>Category</span>
												</span>
											</a>
										 </li>
										 <li class="nav-item {{  $name == 'tag'? 'active': '' }}">
											<a href="{{ route('tag') }}" class="nav-link">
												<span class="nav-text">
												<span>Tag</span>
												</span>
											</a>
										 </li>
									</ul>
							 </div>
							 <b class="sub-arrow"></b>
						</li>
						<li class="nav-item {{ ($controllerName == 'user')? 'active':'' }}">
							<a href="javascript:;" class="nav-link dropdown-toggle">
								<i class="nav-icon fa fa-users"></i>
								<span class="nav-text fadeable">
								<span>User Management</span>
								</span>
								<b class="caret fa fa-angle-left rt-n90"></b>
									<!--
										 <b class="caret caret-shown fa fa-minus text-80"></b>
										 <b class="caret caret-hidden fa fa-plus text-80"></b>
										 -->
							 </a>
							 <div class="hideable submenu collapse {{ ($controllerName == 'user')? 'show':'' }}">
							 	<ul class="submenu-inner">
								 	<li class="nav-item  {{ $name == 'user/form'? 'active': '' }}">
										<a href="{{ route('user/form') }}" class="nav-link">
											<span class="nav-text">
											<span>Add User</span>
											</span>
										</a>
									</li>
								 	<li class="nav-item {{  $name == 'user'? 'active': '' }}">
										<a href="{{ route('user') }}" class="nav-link">
											<span class="nav-text">
												<span>Users</span>
											</span>
										</a>
									</li>
								</ul>
							</div>	
						</li>
				 </ul>
			</div>
			<!-- /.sidebar scroll -->
			<div class="sidebar-section">
				 <div class="sidebar-section-item fadeable-bottom">
						<div class="fadeinable">
							 <div class="pos-rel">
									<img src="{{ asset('admin/assets/image/avatar/avatar4.jpg') }}" width="42" class="radius-round float-left mx-2 border-2 px-1px brc-secondary-m2" />
									<span class="bgc-success-tp2 radius-round border-2 brc-white p-1 position-tr mr-1"></span>
							 </div>
						</div>
						<div class="fadeable hideable w-100 bg-transparent shadow-none border-0">
							 <div id="sidebar-footer-bg" class="bgc-white d-flex align-items-center shadow-sm mx-2 mt-2px py-2 radius-t-1 border-1 border-t-2 border-b-0 brc-primary-m3">
									<div class="d-flex mr-auto py-1">
										 <div class="pos-rel">
												<img src="{{ asset('admin/assets/image/avatar/avatar4.jpg') }}" width="42" class="radius-round float-left mx-2 border-2 px-1px brc-default-m2" />
												<span class="bgc-success-tp2 radius-round border-2 brc-white p-1 position-tr mr-1 mt-1"></span>
										 </div>
										 <div>
												<span class="text-blue font-bolder">Alexa</span>
												<div class="text-80 text-grey">
													 Admin
												</div>
										 </div>
									</div>
									<a href="#" class="btn btn-outline-blue border-0 p-2 mr-2px ml-4" title="Settings" data-toggle="modal" data-target="#id-ace-settings-modal">
									<i class="fa fa-cog text-150"></i>
									</a>
									<a href="page-login" class="btn btn-outline-warning border-0 p-2 mr-1" title="Logout">
									<i class="fa fa-sign-out-alt text-150"></i>
									</a>
							 </div>
						</div>
				 </div>
			</div>
	 </div>
</div>