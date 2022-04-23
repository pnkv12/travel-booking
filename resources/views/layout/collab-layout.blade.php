<?php
$username = auth()->user()->username;
$id = auth()->user()->id;
$role = auth()->user()->role; //KT khi sign in qua auth
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard</title>
    <link rel="icon" href="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('assets/css/admin-style.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('assets/libs/fontawesome-free/css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/fontawesome-free/css/brands.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/fontawesome-free/css/solid.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        .nav {
            font-family: 'Poppins', sans-serif;
        }

        .w-5 {
            display: none;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
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
                            <a class="dropdown-item" href="{{ route('admin.profile', $id) }}"><i class="fas fa-user"></i> Profile</a>
                            <a class="dropdown-item" href="{{ route('admin.changepw', $id) }}"><i class="fas fa-key"></i> Change Password</a>
                            <a class="dropdown-item" href="{{ route('page.upload') }}"><i class="fas fa-image"></i>Photo Library</a>

                            <hr class="my-2">
                            <a class="dropdown-item text-danger" href="{{ route('user.logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                </div>
                </div>
            </nav>
            <nav role="navigation" class="navbar navbar-expand-lg navbar-light bg-info">
                <div class="collapse navbar-collapse">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold {{ (request()->is('collab*')) ? 'active text-info' : 'text-white' }}" href="{{ route('user.collab') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold {{ (request()->is('news*')) ? 'active text-info' : 'text-white' }}" href="{{ route( 'news.list' ) }}">News</a>
                        </li>
                    </ul>
                </div>

            </nav>
    </main>
    @yield('content')
    <footer class="text-center text-lg-start bg-dark text-light">
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <div class="me-5 d-none d-lg-block">
                <span>Applying Laravel in developing Travel Website</span>
            </div>
            <div>
                <span>FPT Greenwich</span>
            </div>
        </section>
        <!-- Section: Info  -->
        <section>
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-gem me-3"></i> About Project
                        </h6>
                        <p>After the pandemic, local travel industry is going to need a boost. The idea of this project is to create a promoting website for domestic tourism.</p>
                    </div>

                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">Language Used</h6>
                        <p>Laravel</p>
                        <p>Boostrap</p>
                    </div>

                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Project Components
                        </h6>
                        <p>
                            <a href="{{route('user.collab')}}" class="text-reset">CMS</a>
                        </p>
                        <p>
                            <a href="#" class="text-reset">VietnamGo's homepage</a>
                        </p>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <!-- Student Info -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Contacts
                        </h6>
                        <p>Pham Ngoc Khanh Vy</p>
                        <p>GCS190289</p>
                        <p><i class="fas fa-home me-3"></i> Ho Chi Minh, Vietnam</p>
                        <p>
                            <i class="fas fa-envelope me-3"></i>
                            vypnkgcs190289@fpt.edu.vn
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </footer>

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
    @yield('after_script')
</body>

</html>