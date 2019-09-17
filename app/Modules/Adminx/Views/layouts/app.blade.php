<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AdminPanel Layout</title>
    <link href="{{ asset('css/default.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/adminx.css') }}" rel="stylesheet" />

    <script src="{{ asset('js/default.js') }}"></script>

</head>
<body id="app-layout">
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                Users List
            </a>

        </div>
    </div>
</nav>
@include('Adminx::layouts.flash_message')
{{ csrf_field() }}
@yield('content')

</body>
</html>