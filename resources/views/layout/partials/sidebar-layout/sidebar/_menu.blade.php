<!--begin::sidebar menu-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
	<!--begin::Menu wrapper-->
	<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
		<!--begin::Menu-->
		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
			<!--begin:Menu item-->
			<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->is('dashboard*') || request()->is('dashboard') ? 'here show' : '' }}">
				<!--begin:Menu item-->
				<div class="menu-item">
					<!--begin:Menu link-->
					{{-- <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
						<span class="menu-bullet">
							<span class="bullet bullet-dot"></span>
						</span>
						<span class="menu-title">Default</span>
					</a> --}}

					@php
						$user = auth()->user();
						$role = $user->role;
					@endphp

					@if($role === 'Admin')
						<a class="menu-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}" href="{{ route('dashboard.admin') }}">
							<span class="menu-icon">
								<i class="ki-duotone ki-chart-simple-2 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
							</span>
							<span class="menu-title">Admin Dashboard</span>
						</a>
						<a class="menu-link {{ request()->routeIs('dashboard.orders') ? 'active' : '' }}" href="{{ route('dashboard.orders') }}">
							<span class="menu-icon">
								<i class="ki-duotone ki-abstract-41 fs-3"><span class="path1"></span><span class="path2"></span></i>
							</span>
							<span class="menu-title">Orders</span>
						</a>

						<a class="menu-link {{ request()->routeIs('dashboard.purchases') ? 'active' : '' }}" href="{{ route('dashboard.purchases') }}">
							<span class="menu-icon">
								<i class="ki-duotone ki-abstract-25 fs-3"><span class="path1"></span><span class="path2"></span></i>
							</span>
							<span class="menu-title">Purchases</span>
						</a>

						<a class="menu-link {{ request()->routeIs('dashboard.userProfits') ? 'active' : '' }}" href="{{ route('dashboard.userProfits') }}">
							<span class="menu-icon">
								<i class="ki-duotone ki-calendar-2 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
							</span>
							<span class="menu-title">User Profits</span>
						</a>

						<a class="menu-link {{ request()->routeIs('dashboard.createProduct') ? 'active' : '' }}" href="{{ route('dashboard.createProduct') }}">
							<span class="menu-icon">
								<i class="ki-duotone ki-element-plus fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
							</span>
							<span class="menu-title">Create New Product</span>
						</a>

						<a class="menu-link {{ request()->routeIs('dashboard.monthlyReports') ? 'active' : '' }}" href="{{ route('dashboard.monthlyReports') }}">
							<span class="menu-icon">
								<i class="ki-duotone ki-calendar-8 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
							</span>
							<span class="menu-title">Monthly Reports</span>
						</a>

						<a class="menu-link {{ request()->routeIs('dashboard.addPost') ? 'active' : '' }}" href="{{ route('dashboard.addPost') }}">
							<span class="menu-icon">
								<i class="ki-duotone ki-abstract-38 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
							</span>
							<span class="menu-title">Add Post</span>
						</a>
					@endif

					@if($role === 'Client')
						<a class="menu-link {{ request()->routeIs('dashboard.client') ? 'active' : '' }}" href="{{ route('dashboard.client') }}">
							<span class="menu-icon">
								<i class="ki-duotone ki-chart-simple-2 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
							</span>
							<span class="menu-title">Client Dashboard</span>
						</a>
						<a class="menu-link {{ request()->routeIs('dashboard.orders') ? 'active' : '' }}" href="{{ route('dashboard.orders') }}">
							<span class="menu-icon">
								<i class="ki-duotone ki-abstract-41 fs-3"><span class="path1"></span><span class="path2"></span></i>
							</span>
							<span class="menu-title">Orders</span>
						</a>
					@endif

					<a class="menu-link {{ request()->routeIs('dashboard.allPosts') ? 'active' : '' }}" href="{{ route('dashboard.allPosts') }}">
						<span class="menu-icon">
							<i class="ki-duotone ki-map fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
						</span>
						<span class="menu-title">News and Updates</span>
					</a>
					<!--end:Menu link-->
				</div>
				<!--end:Menu item-->
			</div>
			<!--end:Menu item-->
			<!--begin:Menu item-->
			@php
				$user = auth()->user();
				$role = $user->role;
			@endphp

			@if($role === 'Admin')
				<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('user-management.*') ? 'here show' : '' }}">
					<!--begin:Menu link-->
					<span class="menu-link">
						<span class="menu-icon">{!! getIcon('abstract-28', 'fs-2') !!}</span>
						<span class="menu-title">User Management</span>
						<span class="menu-arrow"></span>
					</span>
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-accordion">
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{ request()->routeIs('user-management.users.*') ? 'active' : '' }}" href="{{ route('user-management.users.index') }}">
								<span class="menu-icon">
									<i class="ki-duotone ki-user fs-3"><span class="path1"></span><span class="path2"></span></i>
								</span>
								<span class="menu-title">Users</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{ request()->routeIs('user-management.roles.*') ? 'active' : '' }}" href="{{ route('user-management.roles.index') }}">
								<span class="menu-icon">
									<i class="ki-duotone ki-switch fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
								</span>
								<span class="menu-title">Roles</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link {{ request()->routeIs('user-management.permissions.*') ? 'active' : '' }}" href="{{ route('user-management.permissions.index') }}">
								<span class="menu-icon">
									<i class="ki-duotone ki-chart fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
								</span>
								<span class="menu-title">Permissions</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
					</div>
					<!--end:Menu sub-->
				</div>
			@endif
			<!--end:Menu item-->
		</div>
		<!--end::Menu-->
	</div>
	<!--end::Menu wrapper-->
</div>
<!--end::sidebar menu-->
