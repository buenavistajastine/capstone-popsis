<div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li>
							<a href="/dashboard"><span class="menu-side"><img src="assets/img/icons/menu-icon-01.svg" alt=""></span> <span>Dashboard</span></a>
						</li>
						@hasrole(['admin', 'manager'])
						<li class="submenu">
							<a href="#"><span class="menu-side"><i class="fa-solid fa-users"></i></span> <span> Users </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								
								<li><a href="/user">User Management</a></li>
								<li><a href="/list">Customer List</a></li>
								<li><a href="/customer-account">Customer Account</a></li>
								
							</ul>
						</li>
						@endhasrole

						@hasrole(['admin', 'manager', 'Kitchen Staff'])
                        <li>
							<a href="order"><span class="menu-side"><i class="fa-solid fa-basket-shopping"></i></span> <span>Food Order</span></a>
						</li>
                        <li>
							<a href="booking"><span class="menu-side"><i class="fa-solid fa-calendar-day"></i></i></span> <span>Booking</span></a>
						</li>
                        <li>
							<a href="kitchen"><span class="menu-side"><i class="fa-solid fa-fire-burner"></i></i></span> <span>Kitchen</span></a>
						</li>
						@endhasrole
                        {{-- <li>
							<a href="billing"><span class="menu-side"><i class="fa-solid fa-calculator"></i></span> <span>Billing</span></a>
						</li> --}}
						@hasrole(['admin', 'manager'])
						<li class="submenu">
							<a href="#"><i class="fa-solid fa-calculator"></i> <span> Billing </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="booking_billing"> Booking </a></li>
								<li><a href="order_billing"> Food Order </a></li>
							</ul>
						</li>
						@endhasrole

						@hasrole(['admin', 'manager', 'staff'])
						<li class="submenu">
							<a href="#"><i class="fa fa-flag"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="booking_reports"> Booking Report </a></li>
								<li><a href="order_reports"> Food Order Report </a></li>
							</ul>
						</li>
						@endhasrole
						@hasrole(['admin', 'manager'])
                        <li class="menu-title">Setup</li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-columns"></i> <span>System</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="dish"> Dish </a></li>
                                <li><a href="package"> Packages </a></li>
                                <li><a href="status"> Status </a></li>
                            </ul>
                        </li>
						@endhasrole

						@hasrole('admin')
                        <li class="submenu">
                            <a href="javascript:void(0);"><i class="fa fa-share-alt"></i> <span>Authentication</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li>
                                    <a href="/role"><span>Role</span></a>
                                </li>
                                <li>
                                    <a href="/permission"><span>Permission</span></a>
                                </li>
                            </ul>
                        </li>
						@endhasrole
                    </ul>
					<div class="logout-btn">
						<a href="{{ route('logout') }}"><span class="menu-side"><i class="fa-solid fa-right-from-bracket"></i></span> <span>Logout</span></a>
					</div>
                </div>
            </div>
        </div>