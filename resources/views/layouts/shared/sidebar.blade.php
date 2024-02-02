{{-- @if (auth()->user()->hasrole(['doctor', 'staff', 'admin', 'Inquiry']))
@if (!auth()->user()->hasRole('Patient'))
	<div class="sidebar" id="sidebar">
		<div class="sidebar-inner slimscroll">
			<div class="sidebar-menu" id="sidebar-menu">
				<ul>
					<li>
						<a href="/"><span class="menu-side"><i class="fa-solid fa-house"></i></span>
							<span>Dashboard</span></a>
					</li>
					@hasrole(['admin', 'staff'])
						<li class="submenu">
							<a href="#"><span class="menu-side"><i class="fa-solid fa-user-group"></i></span>
								<span>Users</span> <span class="menu-arrow"></span>
							</a>

							<ul style="display: none;">
								@hasrole('admin')
									<li><a href="/user">User Management</a></li>
									<li><a href="/doctor">Doctors</a></li>
									<li><a href="/staff">Staff</a></li>
								@endhasrole
								<li><a href="/patient">Patients</a></li>
							</ul>
						</li>
					@endhasrole
					@hasrole(['doctor', 'staff', 'admin'])
						<li>
							<a href="/appointment"><span class="menu-side"><i class="fa-solid fa-calendar-day"></i></span>
								<span>Appointments</span>
							</a>
						</li>
						<li>
							<a href="/booking"><span class="menu-side"><i class="fa-solid fa-calendar-check"></i></span>
								<span>Booking</span></a>
						</li>
						@hasrole(['staff', 'admin'])
							<li>
								<a href="/billing"><span class="menu-side"><i class="fa-solid fa-wallet"></i></span>
									<span>Billing</span></a>
							</li>
							<li>
								<a href="/requests"><span class="menu-side"><i class="fa-solid fa-hourglass-half"></i></i></span>
									<span>Request</span></a>
							</li>
						@endhasrole
					@endhasrole
					@hasrole(['supervisor', 'encoder', 'admin'])
						<li>
							<a href="/ekonsulta"><span class="menu-side"><i class="fa-solid fa-stethoscope"></i></span>
								<span>Ekonsulta</span>
							</a>
						</li>
					@endhasrole
					@hasrole(['supervisor', 'admin', 'inquiry'])
						<li class="submenu">
							<a href="#"><span class="menu-side"><i class="fa-solid fa-list"></i></span>
								<span>Reports</span> <span class="menu-arrow"></span>
							</a>

							<ul style="display: none;">
								@hasrole(['supervisor', 'admin'])
									<li><a href="/report">Employee Efficiency Report</a></li>
									<li><a href="/billingreport">Front Office Report</a></li>
									<li><a href="/booking_report1">Booking Report </a></li>
								@endhasrole
								<li><a href="/booking_specific_report">Company Report</a></li>
								<li><a href="/company_physical_exam">PE Report</a></li>
								@hasrole(['supervisor', 'admin'])
									<li><a href="/examinationreport">Examination Report</a></li>
								@endhasrole
							</ul>
						</li>
					@endhasrole
					@hasrole(['admin', 'staff'])
						<li class="menu-title">Setup</li>

						<li class="submenu">
							<a href="#"><i class="fa fa-gear"></i> <span>System</span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								@hasrole('admin')
									<li><a href="/status">Status</a></li>
									<li><a href="/specialization">Specialization</a></li>
									<li><a href="/department">Departments</a></li>
									<li><a href="/branch">Branch</a></li>
								@endhasrole
								<li><a href="/services">Services</a></li>
								<li><a href="/company">Companies</a></li>
								<li><a href="/discount">Discount</a></li>
								<li><a href="/units">Unit</a></li>
								<li><a href="/actives">Actives</a></li>
							</ul>
						</li>
						@hasrole('admin')
							<li class="submenu mb-5">
								<a href="#"><i class="fa fa-user-shield"></i> <span>Authentication</span> <span
										class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="/role">Role</a></li>
									<li class="mb-5"><a href="/permission">Permission</a></li>
								</ul>
							</li>
						@endhasrole
					@endhasrole
				</ul>
			</div>
		</div>
	</div>
@endif --}}

<div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
						{{-- <li class="submenu">
							<a href="#"><span class="menu-side"><img src="assets/img/icons/menu-icon-01.svg" alt=""></span> <span> Dashboard </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a class="active" href="index.html">Admin Dashboard</a></li>
								<li><a href="doctor-dashboard.html">Doctor Dashboard</a></li>
								<li><a href="patient-dashboard.html">Patient Dashboard</a></li>
							</ul>
						</li> --}}
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
{{-- 						
                        <li>
							<a href="dish"><span class="menu-side"><i class="fa-solid fa-list"></i></span> <span>Dish</span></a>
						</li> --}}
                        <li>
							<a href="order"><span class="menu-side"><i class="fa-solid fa-basket-shopping"></i></span> <span>Food Order</span></a>
						</li>
                        <li>
							<a href="booking"><span class="menu-side"><i class="fa-solid fa-calendar-day"></i></i></span> <span>Booking</span></a>
						</li>
                        <li>
							<a href="billing"><span class="menu-side"><i class="fa-solid fa-calculator"></i></span> <span>Billing</span></a>
						</li>
						<li class="submenu">
							<a href="#"><i class="fa fa-flag"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="expense-reports.html"> Booking Report </a></li>
								<li><a href="expense-reports.html"> Food Order Report </a></li>
								<li><a href="invoice-reports.html"> Billing Report </a></li>
							</ul>
						</li>
						
						{{-- <li class="submenu">
							<a href="#"><span class="menu-side"><img src="assets/img/icons/menu-icon-03.svg" alt=""></span> <span>Patients </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="patients.html">Patients List</a></li>
								<li><a href="add-patient.html">Add Patients</a></li>
								<li><a href="edit-patient.html">Edit Patients</a></li>
								<li><a href="patient-profile.html">Patients Profile</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><span class="menu-side"><img src="assets/img/icons/menu-icon-08.svg" alt=""></span> <span> Staff </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="staff-list.html">Staff List</a></li>
								<li><a href="add-staff.html">Add Staff</a></li>
								<li><a href="staff-profile.html">Staff Profile</a></li>
								<li><a href="staff-leave.html">Leaves</a></li>
								<li><a href="staff-holiday.html">Holidays</a></li>
								<li><a href="staff-attendance.html">Attendance</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><span class="menu-side"><img src="assets/img/icons/menu-icon-04.svg" alt=""></span> <span> Appointments </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="appointments.html">Appointment List</a></li>
								<li><a href="add-appointment.html">Book Appointment</a></li>
								<li><a href="edit-appointment.html">Edit Appointment</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><span class="menu-side"><img src="assets/img/icons/menu-icon-05.svg" alt=""></span> <span> Doctor Schedule </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="schedule.html">Schedule List</a></li>
								<li><a href="add-schedule.html">Add Schedule</a></li>
								<li><a href="edit-schedule.html">Edit Schedule</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><span class="menu-side"><img src="assets/img/icons/menu-icon-06.svg" alt=""></span> <span> Departments </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="departments.html">Department List</a></li>
								<li><a href="add-department.html">Add Department</a></li>
								<li><a href="edit-department.html">Edit Department</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><span class="menu-side"><img src="assets/img/icons/menu-icon-07.svg" alt=""></span> <span> Accounts </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="invoices.html">Invoices</a></li>
								<li><a href="payments.html">Payments</a></li>
								<li><a href="expenses.html">Expenses</a></li>
								<li><a href="taxes.html">Taxes</a></li>
								<li><a href="provident-fund.html">Provident Fund</a></li>
							</ul>
						</li>
						<li class="submenu">
							<a href="#"><span class="menu-side"><img src="assets/img/icons/menu-icon-09.svg" alt=""></span> <span> Payroll </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="salary.html"> Employee Salary </a></li>
								<li><a href="salary-view.html"> Payslip </a></li>
							</ul>
						</li>
						<li>
							<a href="chat.html"><span class="menu-side"><img src="assets/img/icons/menu-icon-10.svg" alt=""></span> <span>Chat</span></a>
						</li>
                        <li class="submenu">
                            <a href="#"><span class="menu-side"><img src="assets/img/icons/menu-icon-11.svg" alt=""></span> <span> Calls</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="voice-call.html">Voice Call</a></li>
                                <li><a href="video-call.html">Video Call</a></li>
                                <li><a href="incoming-call.html">Incoming Call</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><span class="menu-side"><img src="assets/img/icons/menu-icon-12.svg" alt=""></span> <span> Email</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="compose.html">Compose Mail</a></li>
                                <li><a href="inbox.html">Inbox</a></li>
                                <li><a href="mail-view.html">Mail View</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><span class="menu-side"><img src="assets/img/icons/menu-icon-13.svg" alt=""></span> <span> Blog</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="blog-details.html">Blog View</a></li>
                                <li><a href="add-blog.html">Add Blog</a></li>
                                <li><a href="edit-blog.html">Edit Blog</a></li>
                            </ul>
                        </li>
						<li>
							<a href="assets.html"><i class="fa fa-cube"></i> <span>Assets</span></a>
						</li>
						<li>
							<a href="activities.html"><span class="menu-side"><img src="assets/img/icons/menu-icon-14.svg" alt=""></span> <span>Activities</span></a>
						</li>
						
                        <li class="submenu">
							<a href="#"><span class="menu-side"><img src="assets/img/icons/menu-icon-15.svg" alt=""></span> <span> Invoice </span> <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="invoices-list.html"> Invoices List </a></li>
								<li><a href="invoices-grid.html"> Invoices Grid</a></li>
								<li><a href="add-invoice.html"> Add Invoices</a></li>
								<li><a href="edit-invoices.html"> Edit Invoices</a></li>
								<li><a href="view-invoice.html"> Invoices Details</a></li>
								<li><a href="invoices-settings.html"> Invoices Settings</a></li>
							</ul>
						</li> --}}
                        
                        {{-- <li>
                            <a href="settings.html"><span class="menu-side"><img src="assets/img/icons/menu-icon-16.svg" alt=""></span> <span>Settings</span></a>
                        </li>
                        <li class="menu-title">UI Interface</li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-laptop"></i> <span> Base UI</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="alerts.html">Alerts</a></li>                                    
								<li><a href="accordions.html">Accordions</a></li>
								<li><a href="avatar.html">Avatar</a></li> 
								<li><a href="badges.html">Badges</a></li>
								<li><a href="buttons.html">Buttons</a></li>   
								<li><a href="buttongroup.html">Button Group</a></li>                                  
								<li><a href="breadcrumbs.html">Breadcrumb</a></li>
								<li><a href="cards.html">Cards</a></li>
								<li><a href="carousel.html">Carousel</a></li>                                   
								<li><a href="dropdowns.html">Dropdowns</a></li>
								<li><a href="grid.html">Grid</a></li>
								<li><a href="images.html">Images</a></li>
								<li><a href="lightbox.html">Lightbox</a></li>
								<li><a href="media.html">Media</a></li>                              
								<li><a href="modal.html">Modals</a></li>
								<li><a href="offcanvas.html">Offcanvas</a></li>
								<li><a href="pagination.html">Pagination</a></li>
								<li><a href="popover.html">Popover</a></li>                                    
								<li><a href="progress.html">Progress Bars</a></li>
								<li><a href="placeholders.html">Placeholders</a></li>
								<li><a href="rangeslider.html">Range Slider</a></li>                                    
								<li><a href="spinners.html">Spinner</a></li>
								<li><a href="sweetalerts.html">Sweet Alerts</a></li>
								<li><a href="tab.html">Tabs</a></li>
								<li><a href="toastr.html">Toasts</a></li>
								<li><a href="tooltip.html">Tooltip</a></li>
								<li><a href="typography.html">Typography</a></li>
								<li><a href="video.html">Video</a></li>
                            </ul>
                        </li>
						<li class="submenu">
                            <a href="#"><i class="fa fa-box"></i> <span> Elements</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="ribbon.html">Ribbon</a></li>
								<li><a href="clipboard.html">Clipboard</a></li>
								<li><a href="drag-drop.html">Drag & Drop</a></li>
								<li><a href="rating.html">Rating</a></li>
								<li><a href="text-editor.html">Text Editor</a></li>
								<li><a href="counter.html">Counter</a></li>
								<li><a href="scrollbar.html">Scrollbar</a></li>
								<li><a href="notification.html">Notification</a></li>
								<li><a href="stickynote.html">Sticky Note</a></li>
								<li><a href="timeline.html">Timeline</a></li>
								<li><a href="horizontal-timeline.html">Horizontal Timeline</a></li>
								<li><a href="form-wizard.html">Form Wizard</a></li>
                            </ul>
                        </li>
						<li class="submenu">
                            <a href="#"><i class="fa fa-chart-simple"></i> <span>Charts</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="chart-apex.html">Apex Charts</a></li>
								<li><a href="chart-js.html">Chart Js</a></li>
								<li><a href="chart-morris.html">Morris Charts</a></li>
								<li><a href="chart-flot.html">Flot Charts</a></li>
								<li><a href="chart-peity.html">Peity Charts</a></li>
								<li><a href="chart-c3.html">C3 Charts</a></li>
                            </ul>
                        </li>
						<li class="submenu">
                            <a href="#"><i class="fa fa-award"></i> <span>Icons</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
								<li><a href="icon-fontawesome.html">Fontawesome Icons</a></li>
								<li><a href="icon-feather.html">Feather Icons</a></li>
								<li><a href="icon-ionic.html">Ionic Icons</a></li>
								<li><a href="icon-material.html">Material Icons</a></li>
								<li><a href="icon-pe7.html">Pe7 Icons</a></li>
								<li><a href="icon-simpleline.html">Simpleline Icons</a></li>
								<li><a href="icon-themify.html">Themify Icons</a></li>
								<li><a href="icon-weather.html">Weather Icons</a></li>
								<li><a href="icon-typicon.html">Typicon Icons</a></li>
								<li><a href="icon-flag.html">Flag Icons</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-edit"></i> <span> Forms</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="form-basic-inputs.html">Basic Inputs</a></li>
                                <li><a href="form-input-groups.html">Input Groups</a></li>
                                <li><a href="form-horizontal.html">Horizontal Form</a></li>
                                <li><a href="form-vertical.html">Vertical Form</a></li>
								<li><a href="form-mask.html">Form Mask </a></li>
								<li><a href="form-validation.html">Form Validation </a></li>
								<li><a href="form-select2.html">Form Select2 </a></li>
								<li><a href="form-fileupload.html">File Upload </a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-table"></i> <span> Tables</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="tables-basic.html">Basic Tables</a></li>
                                <li><a href="tables-datatables.html">Data Table</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="calendar.html"><i class="fa fa-calendar"></i> <span>Calendar</span></a>
                        </li> --}}
                        <li class="menu-title">Setup</li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-columns"></i> <span>System</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="dish"> Dish </a></li>
                                <li><a href="package"> Packages </a></li>
                                <li><a href="status"> Status </a></li>
                            </ul>
                        </li>
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