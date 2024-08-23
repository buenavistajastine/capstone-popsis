<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/finalcroplogo1.png">
    <title>Popsis Catering</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Links --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toatr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    <style>
        .dishes-container {
            max-height: 500px;
            overflow-y: auto;
            scrollbar-width: none;
            margin-left: 0px;
            margin-right: 4px;
            padding-right: 10px;
            padding-left: 10px;
            background: linear-gradient(
            0deg,
            rgba(51, 53, 72, 0.05),
            rgba(51, 53, 72, 0.05)
        ),
        #ffffff;
            padding-top: 10px;
            border-radius: 10px;
            border: 1px solid rgba(51, 53, 72, 0.05);
        }

        .dishes-container::-webkit-scrollbar {
            display: none;
        }

        .dish-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 10px;
            margin-bottom: 10px;
        }

        .dish-card small {
            font-size: 0.875rem;
        }

        .counterHead {
            font-size: 14px;
        }

        .custom-dropdown {
            position: relative;
            z-index: 1;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            width: 100%;
            border-radius: 3px;
            background-color: #fff;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            padding-left: 15px;
            padding-right: 15px;
        }

        .custom-dropdown .dropdown-content {
            display: block;
        }

        .dropdown-item {
            padding: 5px;
            cursor: pointer;
        }
    </style>
    @livewireStyles
    @yield('upper_script')
</head>

<body>
    <div class="main-wrapper">
        @include('layouts.shared.header')
        @include('layouts.shared.sidebar')

        <!-- Page Content -->
        <div class="page-wrapper">
            {{ $slot }}
        </div>
        @include('layouts.shared.footer')
        @yield('delete_modal')
    </div>

    <div class="sidebar-overlay" data-reff></div>

    <script src="{{ asset('assets/js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-select.js') }}"></script>
    <script src="{{ asset('assets/js/select2.init.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.js"></script>

    <script>
        Pusher.logToConsole = true;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        window.Echo.channel('orders')
            .listen('OrderCreated', (e) => {
                Livewire.emit('refreshTable');
            });

        window.Echo.channel('bookings')
            .listen('BookingCreated', (e) => {
                Livewire.emit('refreshTable');
            });

        echo.channel('orders')
            .listen('.order.created', (data) => {
                console.log('Order Created:', data);
            });

        echo.channel('bookings')
            .listen('.booking.created', (data) => {
                console.log('Booking Created:', data);
            });
    </script>

    @livewireScripts
    @yield('custom_script')

    @stack('scripts')
</body>

</html>
