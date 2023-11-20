<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    @livewireStyles
    @vite([])
        {{-- Links --}}
        <style>
            html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: Figtree, sans-serif;
            font-feature-settings: normal
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit
        }
        </style>
    
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/prismjs/themes/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo2/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/fontawesome/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/fontawesome/all.css') }}">
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.png') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/content/content/toastr.css') }}">


</head>

<body>
    <div class="main-wrapper">
		@include('layouts.shared.header')
		@include('layouts.shared.sidebar')

		<!-- Page Content -->
		<div class="page-wrapper">
			{{ $slot }}
		</div>
		@yield('delete_modal')
	</div>

	<div class="sidebar-overlay" data-reff></div>
    @livewireScripts

    <script src="{{ asset('backend/assets/vendors/core/core.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/prismjs/prism.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('backend/assets/vendors/feather-icons/feathers.js') }}"></script>
    <script src="{{ asset('backend/assets/js/template.js') }}"></script>
    <script src="{{ asset('backend/assets/js/fontawesome/all.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script src="{{ asset('backend/assets/js/dashboard-dark.js') }}"></script>
    <script src="{{ asset('backend/assets/js/flatpickr.js') }}"></script>
    <script src="{{ asset('backend/assets/js/pickr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/content/scripts/toastr.min.js') }}"></script>

    
    @yield('custom_script')

    @stack('script')

</body>

</html>
