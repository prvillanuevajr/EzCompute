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
                @foreach($categories->where('category_id',null) as $category)
                    <li class="nav-item dropdown">
                        <a href="/shop?category={{$category->name}}" class="nav-link dropdown-toggle"
                           id="navbarDropdownMenuLink"
                           aria-haspopup="true" aria-expanded="false">
                            {{$category->name}}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @foreach($category->categories as $categorya)
                                <li><a class="dropdown-item"
                                       href="/shop?category={{$categorya->name}}">{{$categorya->name}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        {{--<ul class="navbar-nav mr-auto">--}}
        {{--<li class="nav-item dropdown">--}}
        {{--<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"--}}
        {{--data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
        {{--Categories--}}
        {{--</a>--}}
        {{--<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
        {{--@foreach($categories->where('category_id',null) as $category)--}}
        {{--<li class="dropdown-submenu">--}}
        {{--<a class="dropdown-item dropdown-toggle" href="/shop?category={{$category->name}}">{{$category->name}}</a>--}}
        {{--<ul class="dropdown-menu">--}}
        {{--@foreach($category->categories as $categorya)--}}
        {{--<li><a class="dropdown-item" href="/shop?category={{$categorya->name}}">{{$categorya->name}}</a></li>--}}
        {{--@endforeach--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--@endforeach--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--BRANDS--}}
        {{--<li class="nav-item dropdown">--}}
        {{--<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"--}}
        {{--data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
        {{--Brands--}}
        {{--</a>--}}
        {{--<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
        {{--@foreach($brands as $brand)--}}
        {{--<li class="dropdown-submenu"><a class="dropdown-item" href="/shop?brand={{$brand->name}}">{{$brand->name}}</a></li>--}}
        {{--@endforeach--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--</ul>--}}
        <!-- Right Side Of Navbar -->
            <form class="form-inline my-2 my-lg-0" action="/shop">
                <input class="form-control mr-sm-2" type="search" placeholder="Search product"
                       value="{{ app('request')->input('search') }}"
                       name="search" aria-label="Search">
                <button class="btn btn-outline-primary">Search</button>
            </form>
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}"><i
                                    class="fa fa-signing"></i> {{ __('Register') }}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/notifications">
                            <i class="fa fa-bell fa-2x">
                                <span class="badge badge-pill badge-success">{{auth()->user()->unReadNotifications->count()?:''}}</span>
                            </i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/cart" class="nav-link">
                            <i class="fa fa-shopping-cart fa-2x">
                                <span class="badge badge-pill badge-success">{{auth()->user()->carts->count()?:''}}</span>
                            </i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href=""></a>
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa fa-user fa-2x"></i><span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <h6 class="dropdown-header">{{Auth::user()->name}}</h6>
                            <a href="/orders" class="dropdown-item">My Orders</a>
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