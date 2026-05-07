<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Login Admin Bappedalitbang Deli Serdang">
    <meta name="author" content="Bappedalitbang">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Login | Bappedalitbang Deli Serdang')</title>

    <link rel="shortcut icon" href="{{ asset('udema/bappeda/bappeda.png') }}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('udema/bappeda/bappeda.png') }}">

    <link href="{{ asset('udema/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('udema/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('udema/css/vendors.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @stack('styles')
</head>

<body id="login_bg">

    @yield('content')

    <script src="{{ asset('udema/js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('udema/js/common_scripts.js') }}"></script>
    <script src="{{ asset('udema/js/main.js') }}"></script>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('password-input');
            var showPasswordCheckbox = document.getElementById('show-password');

            if (showPasswordCheckbox && showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>

    @stack('scripts')
</body>

</html>
