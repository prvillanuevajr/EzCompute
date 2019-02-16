<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="img-fluid" width="32" src="{{asset('images/Logo.png')}}" alt="">
            EzCompute
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                {{--@foreach($categories->where('category_id',null) as $category)--}}
                    {{--<li></li>--}}
                {{--@endforeach--}}
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Login</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i
                                        class="fa fa-signing"></i> {{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa fa-shopping-bag"><span
                                        class="badge badge-pill badge-primary"></span></i> Cart</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href=""></a>
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa fa-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }} <i class="fa fa-sign-out"></i>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
{{--<div class="top-right links">--}}
{{--<a href=""><i class="fa fa-shopping-bag"></i> My Cart</a>--}}
{{--@auth--}}
{{--<a href="{{ url('/home') }}">Home</a>--}}
{{--<a class="dropdown-item" href="{{ route('logout') }}"--}}
{{--onclick="event.preventDefault(); document.getElementById('logout-form').submit();">--}}
{{--{{ __('Logout') }} <i class="fa fa-sign-out"></i>--}}
{{--</a>--}}
{{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>--}}
{{--@else--}}
{{--<a href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Login</a>--}}
{{--@if (Route::has('register'))--}}
{{--<a href="{{ route('register') }}"><i class="fa fa-signing"></i> Register</a>--}}
{{--@endif--}}
{{--@endauth--}}
{{--</div>--}}
</body>
</html>
