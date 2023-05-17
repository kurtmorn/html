<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ isset($title) ? "{$title} | " . config('site.name') : config('site.name') }}</title>

    <!-- Preconnect -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <!-- Meta -->
    <link rel="shortcut icon" href="{{ config('site.icon') }}">
    <meta name="author" content="{{ config('site.name') }}">
    <meta name="description" content="Explore {{ config('site.name') }}: A free online social hangout.">
    <meta name="keywords" content="{{ strtolower(config('site.name')) }}, {{ strtolower(str_replace(' ', '', config('site.name'))) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <!-- OpenGraph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('site.name') }}">
    <meta property="og:title" content="{{ str_replace(' | ' . config('site.name'), '', $title) }}">
    <meta property="og:description" content="Explore {{ config('site.name') }}: A free online social hangout.">
    <meta property="og:image" content="{{ !isset($image) ? config('site.icon') : $image }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap">
    @yield('fonts')

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ (Auth::check()) ? asset('css/themes/' . Auth::user()->setting->theme . '.css?v=' . rand()) : asset('css/themes/light.css?v=' . rand()) }}">
    <style>
        a:not([href]):not([class]) {
            color: var(--link_color);
            cursor: pointer;
        }
        a:not([href]):not([class]):hover, a:not([href]):not([class]):focus {
            color: var(--link_color_hover);
        }
        a, a:hover, a:focus {
            text-decoration: none;
        }
        .container-custom {
            max-width: 1420px;
        }
        .card, .card-header, .breadcrumb, .form-control, .btn, .nav-pills .nav-link {
            border-radius: 2px!important;
        }
        .navbar-search-dropdown-parent {
            width: 50%;
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1000;
            margin-left: 13%;
        }
        .navbar-search-dropdown {
            background: var(--section_bg);
            color: var(--section_color);
            border-radius: 8px;
            box-shadow: var(--section_box_shadow);
            padding: 15px 0;
            width: 100%;
            position: absolute;
            margin-top: 50px;
        }
        .navbar-search-result, .navbar-search-error {
            padding: 5px;
            padding-left: 10px;
            padding-right: 10px;
        }
        .navbar-search-result:hover {
            background: var(--section_bg_hover);
        }
        .navbar-search-result a {
            color: inherit;
            text-decoration: none;
        }
        .navbar-search-result img {
            background: var(--headshot_bg);
            border: 1px solid var(--headshot_border_color);
            border-radius: 50%;
            width: 40px;
        }
        .sidebar-icon {
            width: 35px!important;
            text-align: center;
        }
       .first-bar {
             background: var(--brand_color);
             box-shadow: none;
       }
       .second-bar {
             background: var(--brand_color_darkened);
             box-shadow: none;
       }
    </style>
    @yield('css')
</head>
  @yield('content')