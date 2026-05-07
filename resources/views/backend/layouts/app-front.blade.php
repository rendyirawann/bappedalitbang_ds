<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Bappedalitbang Deli Serdang">
    <meta name="author" content="Bappedalitbang">

    <title>@yield('title', 'Bappedalitbang Deli Serdang')</title>

    <link rel="shortcut icon" href="{{ asset('udema/bappeda/bappeda.png') }}" type="image/x-icon">

    <link href="{{ asset('udema/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="{{ asset('udema/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('udema/css/vendors.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body>
    <div id="page">

        @include('backend.layouts.navbar-front')

        <main>
            @yield('content')
        </main>

        @include('backend.layouts.footer-front')

    </div>

    <script src="{{ asset('udema/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('udema/js/common_scripts.js') }}"></script>
    <script src="{{ asset('udema/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
