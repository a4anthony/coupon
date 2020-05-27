<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="assets-path" content="{{ route('coupon.coupon_assets') }}" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ Coupon_asset('images/logo-icon.png') }}" type="image/png">

    <!-- Scripts -->
    <!-- <script src="{{ Coupon_asset('js/app.js') }}" defer></script> -->
    <script src="{{ Coupon_asset('js/jquery-2.2.4.min.js')}}"></script>
    <script src="{{ Coupon_asset('js/app.js')}}"></script>
    <script src="{{ Coupon_asset('js/moment.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- App CSS -->
    <link rel="stylesheet" href="{{ Coupon_asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ Coupon_asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ Coupon_asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ Coupon_asset('css/bootstrap-datetimepicker.min.css') }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{Coupon_asset('datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ Coupon_asset('css/style.css') }}">


</head>

<body class="">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm  b-shadow">
            <div class="container">
                <a class="navbar-brand" href="{{ route('coupon.dashboard') }}">
                    Coupon Generator
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('coupon.login') }}">{{ __('Login') }}</a>
                        </li> -->
                        @if (Route::has('register'))
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="">{{ __('Register') }}</a>
                        </li> -->
                        @endif
                        @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('coupon.generate') }}">{{ __('Generate') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('coupon.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('coupon.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script type="text/javascript">
        $(function() {
            $('#expiry').datetimepicker();
        });
    </script>
    <script src="{{ Coupon_asset('js/scripts.js') }}" defer></script>
    <script src="{{ Coupon_asset('datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ Coupon_asset('datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ Coupon_asset('js/bootstrap-datetimepicker.min.js') }}"></script>
</body>

</html>