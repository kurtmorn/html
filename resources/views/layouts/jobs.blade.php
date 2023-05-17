<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ isset($title) ? "{$title} | " . config('site.name') . " Jobs" : config('site.name') . ' Jobs' }}</title>

    <!-- Preconnect -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <!-- Meta -->
    <link rel="shortcut icon" href="{{ config('site.icon') }}">
    <meta name="author" content="{{ config('site.name') }}">
    <meta name="description" content="Launch your career at {{ config('site.name') }} today.">
    <meta name="keywords" content="{{ strtolower(config('site.name')) }}, {{ strtolower(str_replace(' ', '', config('site.name'))) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <!-- OpenGraph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('site.name') }}">
    <meta property="og:title" content="{{ str_replace(' | ' . config('site.name') . ' Jobs', '', $title) }}">
    <meta property="og:description" content="Launch your career at {{ config('site.name') }} today.">
    <meta property="og:image" content="{{ !isset($image) ? config('site.icon') : $image }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap">
    @yield('fonts')

    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand&family=Source+Sans+Pro:ital,wght@0,400;0,600;1,200;1,400;1,600&display=swap">
    <style>
        body {
            background: #eee;
            color: #555;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .site-wrapper {
            margin-top: 80px;
        }

        p:last-child {
            margin-bottom: 0;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Quicksand';
            font-weight: 400;
        }

        .card h1, .card h2, .card h3, .card h4, .card h5, .card h6 {
            font-family: 'Source Sans Pro', sans-serif;
        }

        b, strong {
            font-weight: 600;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .btn {
            box-shadow: none!important;
        }

        [class*='btn-outline-'] {
            font-weight: 600;
            text-transform: uppercase;
        }

        .navbar .navbar-brand {
            margin-top: -5px;
        }

        .navbar .headshot a {
            text-decoration: none;
        }

        .navbar .headshot img {
            background: #eee;
            border-radius: 50%;
        }

        .navbar .headshot .dropdown-toggle {
            margin-right: none!important;
        }

        .navbar .headshot .dropdown-toggle::after {
            border: none!important;
            margin: 0!important;
        }

        .card {
            margin-bottom: 16px;
        }

        .navbar, .card, .breadcrumb {
            box-shadow: 0 .125rem .25rem #0000000c;
        }

        @media only screen and (min-width: 768px) {
            .navbar .headshot {
                margin-left: 10px;
            }

            .show-sm-only {
                display: none !important
            }

            .mb-sm-only {
                margin-bottom: 0 !important
            }

            .nav-tabs.card-header-nav-tabs {
                margin-bottom: -5px
            }
        }

        @media only screen and (max-width: 768px) {
            .hide-sm {
                display: none !important
            }

            .full-width-sm {
                width: 100% !important
            }

            .text-center-sm {
                text-align: center !important
            }
        }
    </style>
    @yield('css')
</head>
<body>
    <nav class="navbar navbar-light bg-white navbar-expand-md fixed-top">
        <div class="container">
            <div class="show-sm-only" style="margin-right:60px;"></div>

            <a href="{{ route('jobs.about.index') }}" class="navbar-brand">
                <img class="hide-sm" src="{{ config('site.logo') }}" width="150px">
                <img class="show-sm-only" src="{{ config('site.icon') }}" width="40px">
            </a>

            <button class="navbar-toggler" style="border:none;" type="button" data-toggle="collapse" data-target="#navbarContent">
                <i class="fas fa-bars" style="font-size: 23px;"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mr-2">
                        <a href="{{ route('jobs.listings.index') }}" class="nav-link">
                            <i class="fas fa-list mr-1"></i>
                            <span>Listings</span>
                        </a>
                    </li>
                    <li class="nav-item mr-2">
                        <a href="{{ route('jobs.about.index') }}" class="nav-link">
                            <i class="fas fa-question mr-1"></i>
                            <span>About Us</span>
                        </a>
                    </li>
                    @guest
                        <li class="nav-item mr-2">
                            <a href="{{ route('jobs.login.index') }}" class="nav-link">
                                <i class="fas fa-user mr-1"></i>
                                <span>Login</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('jobs.track.index') }}" class="ml-2 hide-sm">
                                <button class="btn btn-outline-success">Track Application Status</button>
                            </a>
                            <a href="{{ route('jobs.track.index') }}" class="nav-link show-sm-only">
                                <i class="fas fa-analytics mr-1"></i>
                                <span>Track Application Status</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown headshot hide-sm">
                            <a href="#" class="dropdown-toggle headshot" data-toggle="dropdown">
                                <img src="{{ Auth::user()->headshot() }}" width="40px">
                            </a>
                            <div class="dropdown-menu">
                                <a href="{{ route('jobs.logout') }}" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </a>
                            </a>
                        </li>
                        <li class="nav-item show-sm-only">
                            <a href="{{ route('jobs.logout') }}" class="nav-link">
                                <i class="fas fa-sign-out mr-1"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="site-wrapper container">
        @if (count($errors) > 0)
            <div class="alert bg-danger text-white">
                @foreach ($errors->all() as $error)
                    <div>{!! $error !!}</div>
                @endforeach
            </div>
        @endif

        @if (session()->has('success_message'))
            <div class="alert bg-success text-white">
                {!! session()->get('success_message') !!}
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="container text-center mb-5 mt-5">
        <div><strong>Copyright &copy; {{ config('site.name') }} {{ date('Y') }}</strong>.</div>
    </footer>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        var _token;

        $(() => {
            _token = $('meta[name="csrf-token"]').attr('content');
        });
    </script>
    @yield('js')
</body>
