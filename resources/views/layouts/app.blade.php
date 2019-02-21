<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="uid" content="{{ auth()->id() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <script>
        window.user = {!! !auth()->check() ?: auth()->user() !!};
    </script>
    <style>
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
    $('.datatable').DataTable()
    @if($errors->any())
    Swal.fire('Ooops!','{{$errors->first()}}','error');
    @endif
</script>
@yield('scripts')
</body>
</html>
