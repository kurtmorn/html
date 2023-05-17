@extends('layouts.jobs', [
    'title' => 'About Us'
])

@section('css')
    <style>
        .navbar {
            background: #00000099!important;
            box-shadow: none;
        }

        .navbar .navbar-toggler {
            color: #fff;
        }

        .navbar .navbar-brand, .navbar .nav-link {
            color: #fff!important;
            font-weight: 600;
        }

        .navbar .headshot img {
            background: #29272773;
        }

        .site-wrapper {
            margin-top: 0;
        }

        .teaser {
            background: url('{{ asset('img/jobs/banner.png') }}') no-repeat center;
            background-color: #2c2929;
            background-size: cover;
            width: 100%;
            height: 700px;
        }

        img.teaser-logo {
            width: 400px;
            margin: 0 auto;
            margin-top: -850px;
        }

        .teaser-card {
            max-width: 600px;
            margin: 0 auto;
            margin-top: -375px;
            margin-bottom: 275px;
        }

        @media only screen and (max-width: 768px) {
            img.teaser-logo {
                width: 350px;
            }

            .teaser-card {
                max-width: 375px;
            }
        }
    </style>
@endsection

@section('content')
    </div>
    <header class="teaser"></header>
    <div class="text-center">
        <img src="{{ config('site.logo') }}" class="teaser-logo">
    </div>
    <div class="teaser-card header-card card text-center">
        <div class="card-body">
            <h3>A free online social hangout</h3>
            <p>Lets get started.</p>
            <a href="{{ route('jobs.listings.index') }}" class="btn btn-outline-success">Browse Positions</a>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card text-center">
                    <div class="card-body">
                        <h3>About Us</h3>
                        <p>To be written.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
