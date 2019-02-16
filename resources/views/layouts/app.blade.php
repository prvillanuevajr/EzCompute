<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <style>
        .navbar-nav li:hover > ul.dropdown-menu {
            display: block;
        }
    </style>
</head>
<body>
<div id="app">

    @admin
    @include('layouts.admin_navbar')
    @else
        @include('layouts.navbar')
        @endadmin
        <main class="container-fluid py-4">
            @yield('content')
        </main>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
<script>
    $('table').DataTable()
</script>
@yield('scripts')
</body>
</html>