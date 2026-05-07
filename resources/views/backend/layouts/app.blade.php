<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard | Bappedalitbang')</title>

    <link rel="shortcut icon" href="{{ asset('udema/bappeda/bappeda.png') }}" type="image/x-icon">

    <link href="{{ asset('udema-admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('udema-admin/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('udema-admin/vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('udema-admin/css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('udema-admin/css/custom.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="fixed-nav sticky-footer" id="page-top">

    @include('backend.layouts.navbar')

    @yield('content')

    @include('backend.layouts.footer')

    <script src="{{ asset('udema-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('udema-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('udema-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('udema-admin/vendor/chart.js/Chart.js') }}"></script>
    <script src="{{ asset('udema-admin/vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('udema-admin/vendor/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('udema-admin/vendor/jquery.selectbox-0.2.js') }}"></script>
    <script src="{{ asset('udema-admin/vendor/retina-replace.min.js') }}"></script>
    <script src="{{ asset('udema-admin/vendor/jquery.magnific-popup.min.js') }}"></script>

    <script src="{{ asset('udema-admin/js/admin.js') }}"></script>
    <script src="{{ asset('udema-admin/js/admin-charts.js') }}"></script>
    <script src="{{ asset('udema-admin/js/admin-datatables.js') }}"></script>
    <script src="{{ asset('udema-admin/js/admin-charts-all.js') }}"></script>

    @stack('scripts')
</body>

</html>
