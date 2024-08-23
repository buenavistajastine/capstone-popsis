<style>
	#back-to-top-button {
		position: fixed;
		bottom: 20px;
		/* Adjust the distance from the bottom as needed */
		right: 20px;
		/* Adjust the distance from the right as needed */
		/* display: none; */
		z-index: 999;
		/* Ensure it's above other elements */
		cursor: pointer;
	}

	.mobile-user-menu {
		position: absolute;
		top: 10px;
		right: 10px;
	}
</style>

<div class="header">
	<div class="header-left">
		<a href="/" class="logo">
			<img src="{{ asset('assets/img/finalcroplogo1.png') }}" width="60" height="50" alt> <span>Popsi's</span>
		</a>
	</div>
	<a id="toggle_btn" href="#"><img src="{{ asset('assets/img/icons/bar-icon.svg') }}" alt></a>
	@if (!auth()->user()->hasRole('Patient'))
		<a id="mobile_btn" class="mobile_btn float-start" href="#sidebar"><img
				src="{{ asset('assets/img/icons/bar-icon.svg') }}" alt></a>
	@endif
	{{-- <div class="top-nav-search mob-view">
		<form>
			<input type="text" class="form-control" placeholder="Search here">
			<a class="btn"><img src="{{ asset('assets/img/icons/search-normal.svg') }}" alt></a>
		</form>

	</div> --}}
	<a href="#top" id="back-to-top-button" alt>
		<i class="fa-solid fa-arrow-up"></i> <!-- Use the appropriate icon class here -->
	</a>

	<ul class="nav user-menu float-end">

		{{-- Notification --}}

		{{-- <li class="nav-item dropdown d-none d-md-block">
			<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown"><img src="assets/img/icons/note-icon-02.svg" alt=""><span class="pulse"></span> </a>
			<div class="dropdown-menu notifications">
				<div class="topnav-dropdown-header">
					<span>Notifications</span>
				</div>
				<div class="drop-scroll">
					<ul class="notification-list">
						@foreach (auth()->user()->unreadNotifications as $notification)
							<li class="notification-message">
								<a href="{{ route('notifications.markAsRead', $notification->id) }}">
									<div class="media">
										<span class="avatar">
											<img alt="User Avatar" src="assets/img/user.jpg" class="img-fluid">
										</span>
										<div class="media-body">
											<p class="noti-details">
												<span class="noti-title">{{ $notification->data['message'] }}</span>
											</p>
											<p class="noti-time"><span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span></p>
										</div>
									</div>
								</a>
							</li>
						@endforeach
					</ul>
					
				</div>
				<div class="topnav-dropdown-footer">
					<a href="activities.html">View all Notifications</a>
				</div>
			</div>
		</li> --}}

		{{-- End Notification --}}

		<li class="nav-item dropdown has-arrow user-profile-list">

			<a href="#" class="dropdown-toggle nav-link user-link" data-bs-toggle="dropdown">
				<div class="user-names">
					<h5>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h5>
					<span class="text-capitalize">{{ auth()->user()->roles[0]->name }}</span>
				</div>
				<span class="user-img">
					<img src="{{ auth()->user()->photo ? 'storage/images/' . auth()->user()->photo : asset('assets/img/user.jpg') }}" alt="User Photo">
					{{-- <img src="{{ asset('assets/img/user.jpg') }}" alt="User Photo"> --}}
				</span>
			</a>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="{{ route('logout') }}"
					onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					Logout
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</a>
			</div>
		</li>
		{{-- <span class="mx-auto d-block m-auto p-4 text-center">
			<a class="nav-item btn-sm" href="{{ route('logout') }}"
				onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
					class="fa-solid fa-right-from-bracket"></i> Logout</a>
		</span> --}}
	</ul>
{{-- 
	<div class="dropdown mobile-user-menu float-end">
		<span>
			<a class="btn btn-sm btn-primary" href="{{ route('logout') }}"
				onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				<i class="fa-solid fa-right-from-bracket"></i>
			</a>
		</span>
	</div> --}}
</div>
