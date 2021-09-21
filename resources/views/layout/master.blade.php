<?php
$username = auth()->user()->username; //KT khi sign in qua auth
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard</title>
    <link rel="icon" href="">
    <link href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/admin-style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/fontawesome-free/css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/fontawesome-free/css/brands.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/fontawesome-free/css/solid.css') }}" rel="stylesheet">
    <style>
        .w-5 {
            display: none;
        }
    </style>
</head>

<body class="container">
    <main>
        <section class="menu">
            <nav role="navigation" class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a class="navbar-brand text-white font-weight-bold">VietnamGo CMS</a>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hi, <span class="text-light font-weight-bold">{{$username}}</span>!
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#"><i class="fas fa-key"></i> Change Password</a>
                            <a class="dropdown-item red" href="{{ route('user.logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                </div>
                </div>
            </nav>
            <nav role="navigation" class="navbar navbar-expand-lg navbar-light bg-info">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-white font-weight-bold" href="{{ route( 'user.index' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white font-weight-bold" href="{{ route( 'news.list' ) }}">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white font-weight-bold" href="#">Tours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white font-weight-bold" href="{{ route('admin.list') }}">Contacts</a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <!-- <a class="nav-link text-white font-weight-bold" href="#">Booking Query</a> -->
                            <button class="btn btn-light my-2 my-sm-0 font-weight-bold" href="#">Booking Query</button>
                        </li>
                    </ul>
                </div>
            </nav>
    </main>
    @yield('content')
    <footer class="container-fluid bg-dark" style="height: 100px;">
    </footer>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>
    window.jQuery || document.write('<script src="{{ asset('
        assets / js / vendor / jquery - slim.min.js ') }}"><\/script>')
</script>
<script src="{{ asset('assets/js/vendor/popper.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    //javascript here
</script>

</html>