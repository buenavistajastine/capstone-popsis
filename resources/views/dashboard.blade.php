<x-app-layout>

    <div class="content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard </a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">Admin Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="good-morning-blk">
            <div class="row">
                <div class="col-md-6">
                    <div class="morning-user">
                        <h2>
                            @if ($time < 0)
                                Good Morning,
                            @elseif ($time < 6)
                                Good Afternoon,
                            @else
                                Good Evening,
                            @endif <span class="text-capitalize">
                                {{ auth()->user()->first_name }}
                                {{ auth()->user()->last_name }}
                            </span>
                        </h2>
                        <p>Have a nice day at work</p>
                    </div>
                </div>
                <div class="col-md-6 position-blk">
                    <div class="morning-img">
                        <img src="assets/img/morning-img-01.png" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <div class="dash-boxs comman-flex-center">
                        <img src="assets/img/icons/calendar.svg" alt="">
                    </div>
                    <div class="dash-content dash-count">
                        <h4>Bookings</h4>
                        <h2><span class="counter-up">{{ $bookings->count() }}</span></h2>
                        {{-- <p><span class="passive-view"><i class="feather-arrow-up-right me-1"></i>40%</span> vs last
                            month</p> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <div class="dash-boxs comman-flex-center">
                        <img src="assets/img/icons/profile-add.svg" alt="">
                    </div>
                    <div class="dash-content dash-count">
                        <h4>Customers</h4>
                        <h2><span class="counter-up">{{ $customers->count() }}</span></h2>
                        {{-- <p><span class="passive-view"><i class="feather-arrow-up-right me-1"></i>20%</span> vs last
                            month</p> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <div class="dash-boxs comman-flex-center">
                        <img src="assets/img/icons/scissor.svg" alt="">
                    </div>
                    <div class="dash-content dash-count">
                        <h4>Food Orders</h4>
                        <h2><span class="counter-up">{{ $orders->count() }}</span></h2>
                        {{-- <p><span class="negative-view"><i class="feather-arrow-down-right me-1"></i>15%</span> vs last
                            month</p> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <div class="dash-boxs comman-flex-center">
                        <img src="assets/img/icons/empty-wallet.svg" alt="">
                    </div>
                    <div class="dash-content dash-count">
                        <h4>Earnings</h4>
                        <h2>₱<span class="counter-up">{{ number_format($totalEarnings, 2) }}</span></h2>
                        {{-- <p><span class="passive-view"><i class="feather-arrow-up-right me-1"></i>30%</span> vs last
                            month</p> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-12 col-md-12 col-lg-6 col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-title patient-visit">
                            <h4>Patient Visit by Gender</h4>
                            <div>
                                <ul class="nav chat-user-total">
                                    <li><i class="fa fa-circle current-users" aria-hidden="true"></i>Male 75%</li>
                                    <li><i class="fa fa-circle old-users" aria-hidden="true"></i> Female 25%</li>
                                </ul>
                            </div>
                            <div class="input-block mb-0">
                                <select class="form-control select">
                                    <option>2022</option>
                                    <option>2021</option>
                                    <option>2020</option>
                                    <option>2019</option>
                                </select>
                            </div>
                        </div>
                        <div id="patient-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-6 col-xl-3 d-flex">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-title">
                            <h4>Patient by Department</h4>
                        </div>
                        <div id="donut-chart-dash" class="chart-user-icon">
                            <img src="assets/img/icons/user-icon.svg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12  col-xl-4">
                <div class="card top-departments">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Top Departments</h4>
                    </div>
                    <div class="card-body">
                        <div class="activity-top">
                            <div class="activity-boxs comman-flex-center">
                                <img src="assets/img/icons/dep-icon-01.svg" alt="">
                            </div>
                            <div class="departments-list">
                                <h4>General Physician</h4>
                                <p>35%</p>
                            </div>
                        </div>
                        <div class="activity-top">
                            <div class="activity-boxs comman-flex-center">
                                <img src="assets/img/icons/dep-icon-02.svg" alt="">
                            </div>
                            <div class="departments-list">
                                <h4>Dentist</h4>
                                <p>24%</p>
                            </div>
                        </div>
                        <div class="activity-top">
                            <div class="activity-boxs comman-flex-center">
                                <img src="assets/img/icons/dep-icon-03.svg" alt="">
                            </div>
                            <div class="departments-list">
                                <h4>ENT</h4>
                                <p>10%</p>
                            </div>
                        </div>
                        <div class="activity-top">
                            <div class="activity-boxs comman-flex-center">
                                <img src="assets/img/icons/dep-icon-04.svg" alt="">
                            </div>
                            <div class="departments-list">
                                <h4>Cardiologist</h4>
                                <p>15%</p>
                            </div>
                        </div>
                        <div class="activity-top mb-0">
                            <div class="activity-boxs comman-flex-center">
                                <img src="assets/img/icons/dep-icon-05.svg" alt="">
                            </div>
                            <div class="departments-list">
                                <h4>Opthomology</h4>
                                <p>20%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12  col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline-block">Upcoming Appointments</h4> <a href="appointments.html"
                            class="patient-views float-end">Show all</a>
                    </div>
                    <div class="card-body p-0 table-dash">
                        <div class="table-responsive">
                            <table class="table mb-0 border-0 datatable custom-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </th>
                                        <th>No</th>
                                        <th>Patient name</th>
                                        <th>Doctor</th>
                                        <th>Time</th>
                                        <th>Disease</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>R00001</td>
                                        <td>Andrea Lalema</td>
                                        <td class="table-image appoint-doctor">
                                            <img width="28" height="28" class="rounded-circle"
                                                src="assets/img/profiles/avatar-02.jpg" alt="">
                                            <h2>Dr.Jenny Smith</h2>
                                        </td>
                                        <td class="appoint-time"><span>12.05.2022 at </span>7.00 PM</td>
                                        <td><button class="custom-badge status-green ">Fracture</button></td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="edit-appointment.html"><i
                                                            class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#delete_appointment"><i
                                                            class="fa fa-trash-alt m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>R00002</td>
                                        <td>Cristina Groves</td>
                                        <td class="table-image appoint-doctor">
                                            <img width="28" height="28" class="rounded-circle"
                                                src="assets/img/profiles/avatar-03.jpg" alt="">
                                            <h2>Dr.Angelica Ramos</h2>
                                        </td>
                                        <td class="appoint-time"><span>13.05.2022 at </span>7.00 PM</td>
                                        <td><button class="custom-badge status-green">Fever</button></td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="edit-appointment.html"><i
                                                            class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#delete_appointment"><i
                                                            class="fa fa-trash-alt m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>R00003</td>
                                        <td>Bernardo </td>
                                        <td class="table-image appoint-doctor">
                                            <img width="28" height="28" class="rounded-circle"
                                                src="assets/img/profiles/avatar-04.jpg" alt="">
                                            <h2>Dr.Martin Doe</h2>
                                        </td>
                                        <td class="appoint-time"><span>14.05.2022 at </span>7.00 PM</td>
                                        <td><button class="custom-badge status-green">Fracture</button></td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="edit-appointment.html"><i
                                                            class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#delete_appointment"><i
                                                            class="fa fa-trash-alt m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>R00004</td>
                                        <td>Galaviz Lalema</td>
                                        <td class="table-image appoint-doctor">
                                            <img width="28" height="28" class="rounded-circle"
                                                src="assets/img/profiles/avatar-05.jpg" alt="">
                                            <h2>Dr.William Jerk</h2>
                                        </td>
                                        <td class="appoint-time"><span>15.05.2022 at </span>7.00 PM</td>
                                        <td><button class="custom-badge status-green">Fracture</button></td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="edit-appointment.html"><i
                                                            class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#delete_appointment"><i
                                                            class="fa fa-trash-alt m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>R00005</td>
                                        <td>Cristina Groves</td>
                                        <td class="table-image appoint-doctor">
                                            <img width="28" height="28" class="rounded-circle"
                                                src="assets/img/profiles/avatar-03.jpg" alt="">
                                            <h2>Dr.Angelica Ramos</h2>
                                        </td>
                                        <td class="appoint-time"><span>16.05.2022 at </span>7.00 PM</td>
                                        <td><button class="custom-badge status-green">Fever</button></td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="edit-appointment.html"><i
                                                            class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#delete_appointment"><i
                                                            class="fa fa-trash-alt m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="card-title d-inline-block">Recent Patients </h4> <a href="patients.html"
                            class="float-end patient-views">Show all</a>
                    </div>
                    <div class="card-block table-dash">
                        <div class="table-responsive">
                            <table class="table mb-0 border-0 datatable custom-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </th>
                                        <th>No</th>
                                        <th>Patient name</th>
                                        <th>Age</th>
                                        <th>Date of Birth</th>
                                        <th>Diagnosis</th>
                                        <th>Triage</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>R00001</td>
                                        <td class="table-image">
                                            <img width="28" height="28" class="rounded-circle"
                                                src="assets/img/profiles/avatar-02.jpg" alt="">
                                            <h2>Andrea Lalema</h2>
                                        </td>
                                        <td>21</td>
                                        <td>07 January 2002</td>
                                        <td>Heart attack</td>
                                        <td><button class="custom-badge status-green ">Non Urgent</button></td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="edit-patient.html"><i
                                                            class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#delete_appointment"><i
                                                            class="fa fa-trash-alt m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>R00002</td>
                                        <td class="table-image">
                                            <img width="28" height="28" class="rounded-circle"
                                                src="assets/img/profiles/avatar-03.jpg" alt="">
                                            <h2>Mark Hay Smith</h2>
                                        </td>
                                        <td>23</td>
                                        <td>06 January 2002</td>
                                        <td>Jaundice</td>
                                        <td><button class="custom-badge status-pink">Emergency</button></td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="edit-patient.html"><i
                                                            class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#delete_appointment"><i
                                                            class="fa fa-trash-alt m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>R00003</td>
                                        <td class="table-image">
                                            <img width="28" height="28" class="rounded-circle"
                                                src="assets/img/profiles/avatar-04.jpg" alt="">
                                            <h2>Cristina Groves</h2>
                                        </td>
                                        <td>25</td>
                                        <td>10 January 2002</td>
                                        <td>Malaria</td>
                                        <td><button class="custom-badge status-gray">Out Patient</button></td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="edit-patient.html"><i
                                                            class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#delete_appointment"><i
                                                            class="fa fa-trash-alt m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check check-tables">
                                                <input class="form-check-input" type="checkbox" value="something">
                                            </div>
                                        </td>
                                        <td>R00004</td>
                                        <td class="table-image">
                                            <img width="28" height="28" class="rounded-circle"
                                                src="assets/img/profiles/avatar-05.jpg" alt="">
                                            <h2>Galaviz Lalema</h2>
                                        </td>
                                        <td>21</td>
                                        <td>09 January 2002</td>
                                        <td>Typhoid</td>
                                        <td><button class="custom-badge status-orange">Non Urgent</button></td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="edit-patient.html"><i
                                                            class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#delete_appointment"><i
                                                            class="fa fa-trash-alt m-r-5"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="notification-box">
        <div class="msg-sidebar notifications msg-noti">
            <div class="topnav-dropdown-header">
                <span>Messages</span>
            </div>
            <div class="drop-scroll msg-list-scroll" id="msg_list">
                <ul class="list-box">
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">R</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Richard Miles </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item new-message">
                                <div class="list-left">
                                    <span class="avatar">J</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">John Doe</span>
                                    <span class="message-time">1 Aug</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">T</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Tarah Shropshire </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">M</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Mike Litorus</span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">C</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Catherine Manseau </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">D</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Domenic Houston </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">B</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Buster Wigton </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">R</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Rolland Webber </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">C</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"> Claire Mapes </span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">M</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Melita Faucher</span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">J</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Jeffery Lalor</span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">L</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Loren Gatlin</span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="chat.html">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">T</span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author">Tarah Shropshire</span>
                                    <span class="message-time">12:28 AM</span>
                                    <div class="clearfix"></div>
                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur
                                        adipiscing</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="topnav-dropdown-footer">
                <a href="chat.html">See all messages</a>
            </div>
        </div>
    </div>
    </div>

</x-app-layout>
