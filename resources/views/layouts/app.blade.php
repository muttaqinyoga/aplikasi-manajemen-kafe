<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Aplikasi Kasir</title>
    <script src="{{ asset('js/app.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <style type="text/css">
    .spinner-border {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border-width: .2em;
        vertical-align: text-bottom;
        border: .25em solid;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner .75s linear infinite;
    }
    .spinner-borders {
        display: inline-block;
        width: 3rem;
        height: 3rem;
        vertical-align: text-bottom;
        border: .25em solid #512da8;
        border-right-color: transparent;
        border-radius: 50%;
        animation: spinner .75s linear infinite;
    }
    @keyframes spinner {
      to { transform: rotate(360deg); }
    }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-laravel bg-success">
            <div class="container">
                <a class="navbar-brand text-white">
                    Aplikasi Kasir
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @guest
                @else
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if(Auth::user()->role == 62)
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{url('/')}}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{url('admin/users')}}">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{url('admin/menu')}}">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{url('admin/table')}}">Meja</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{url('/pesanan')}}">Pesanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{url('admin/pembayaran')}}">Pembayaran</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{url('/pesanan')}}">Pesanan</a>
                        </li>
                        @endif
                        
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
                @endguest
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @yield('script')
</body>
</html>
