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
<body>
  <header>
<nav class="navbar navbar-expand-md first-bar">
	<div class="container">
      <a class="navbar-brand show-sm-only" style="padding-right:30px;"></a>
       <a href="{{ (Auth::check()) ? route('home.dashboard') : route('home.index') }}" class="navbar-brand">
            <img src="{{ config('site.icon') }}" width="40px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown">
			<i class="fas fa-bars"></i>
		</button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a href="{{ route('catalog.index') }}" class="nav-link">
						<i class="fas fa-shopping-bag"></i>
						<span class="mb-0">Market</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('users.index') }}" class="nav-link">
						<i class="fas fa-users"></i>
						<span>People</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('forum.index') }}" class="nav-link">
						<i class="fas fa-comment-smile"></i>
						<span>Discussion</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('groups.index') }}" class="nav-link">
						<i class="fas fa-building"></i>
						<span>Clubs</span>
					</a>
				</li>
              
             @if (Auth::check() && Auth::user()->isStaff())
             <li class="nav-item">
                <a href="{{ route('admin.index') }}" class="nav-link">
                    <i class="fas fa-gavel"></i>
                    <span class="sidebar-text">Panel</span>
                </a>
            </li>  
            @endif
              
			</ul>
        @guest
            <div class="nav-item show-sm-only"></div>
        @else
            <div class="nav-item dropdown headshot show-sm-only">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ Auth::user()->headshot() }}" width="40px">
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('auth.logout') }}" class="dropdown-item">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        @endguest
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item hide-sm">
                        <a href="{{ route('auth.login.index') }}" class="nav-link">
                            <i class="fas fa-user"></i>
                            <span>Login</span>
                        </a>
                    </li>
                    @if (site_setting('registration_enabled'))
                        <li class="nav-item hide-sm">
                            <a href="{{ route('auth.register.index') }}" class="nav-link">
                                <i class="fas fa-user-plus"></i>
                                <span>Register</span>
                            </a>
                        </li>
                    @endif
                @else
                 @if (Auth::check() && Auth::user()->isStaff())
                    <li class="nav-item">
						<a href="{{ route('admin.asset_approval.index', '') }}" class="nav-link">
							<i class="fas fa-tshirt"></i>
							<span>{{ number_format(pendingAssetsCount()) }}</span>
						</a>
					</li>
                    <li class="nav-item">
						<a href="{{ route('admin.reports.index') }}" class="nav-link">
							<i class="fas fa-flag"></i>
							<span>{{ number_format(pendingReportsCount()) }}</span>
						</a>
					</li>
                @endif
                    <li class="nav-item">
						<a href="{{ route('account.trades.index', '') }}" class="nav-link">
							<i class="fas fa-exchange"></i>
							<span>{{ number_format(Auth::user()->tradeCount()) }}</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ route('account.inbox.index', '') }}" class="nav-link">
							<i class="fas fa-inbox"></i>
							<span>{{ number_format(Auth::user()->messageCount()) }}</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ route('account.friends.index') }}" class="nav-link">
							<i class="fas fa-user-plus"></i>
							<span>{{ number_format(Auth::user()->friendRequestCount()) }}</span>
						</a>
					</li>
                    <li class="nav-item">
                        <a href="{{ route('account.money.index', '') }}" class="nav-link" title="{{ str_replace('from now', '', Auth::user()->next_currency_payout->diffForHumans()) }} until next reward" data-toggle="tooltip">
                            <i class="far fa-usd-circle"></i>
                            <span>{{ number_format(Auth::user()->currency) }}</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown headshot hide-sm">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ Auth::user()->headshot() }}" width="40px">
                        </a>
                        <div class="dropdown-menu" style="margin-left:-100px;">
                            <a href="{{ route('auth.logout') }}" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>
                @endguest
            </ul>
      </div>
  </div>
</nav>
</header>
  @auth
  <nav class="navbar navbar-expand-sm second-bar" id="main-bar">
   <div class="container">
  <ul class="navbar-nav">
                    <li class="nav-item">
						<a href="{{ (Auth::check()) ? route('home.dashboard') : route('home.index') }}" class="nav-link">
							<i class="fas fa-home"></i>
							<span>Home</span>
						</a>
					</li>
                    @if (site_setting('settings_enabled'))
                    <li class="nav-item">
						<a href="{{ route('account.settings.index', '') }}" class="nav-link">
							<i class="fas fa-wrench"></i>
							<span>Settings</span>
						</a>
					</li>
                    @endif
                   @if (site_setting('character_enabled'))
                   <li class="nav-item">
						<a href="{{ route('account.character.index') }}" class="nav-link">
							<i class="fas fa-male"></i>
							<span>Character</span>
						</a>
					</li>
                    @endif
                    <li class="nav-item">
						<a href="{{ route('users.profile', Auth::user()->username) }}" class="nav-link">
							<i class="fas fa-user"></i>
							<span>Profile</span>
						</a>
					</li>
                    <li class="nav-item">
						<a href="{{ route('creator_area.index') }}" class="nav-link">
							<i class="fas fa-plus"></i>
							<span>Create</span>
						</a>
					</li>
                    <li class="nav-item">
						<a href="{{ route('account.money.index', '') }}" class="nav-link">
							<i class="fas fa-cash-register"></i>
							<span>Money</span>
						</a>
					</li>
                    <li class="nav-item">
						<a href="{{ route('account.promocodes.index') }}" class="nav-link">
							<i class="fas fa-medal"></i>
							<span>Promocodes</span>
						</a>
					</li>
                   @if (site_setting('real_life_purchases_enabled'))
					<li class="nav-item">
						<a href="{{ route('account.upgrade.index') }}" class="nav-link">
							<i class="fas fa-rocket"></i>
							<span>Level Up</span>
						</a>
					</li>
                   @endif
					
    </ul>
    </div>
  </nav>
  @endauth
  <br>
<main class="container">
        @if (site_setting('alert_enabled') && site_setting('alert_message'))
            <div class="alert alert-site text-center mb-4" style="background:{{ site_setting('alert_background_color') }};color:{{ site_setting('alert_text_color') }};">
                <div class="row">
                    <div class="col-1 align-self-center pl-1 pr-1">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="col-10 align-self-center pl-1 pr-1">
                        <strong style="word-wrap:break-word;">{!! site_setting('alert_message') !!}</strong>
                    </div>
                    <div class="col-1 align-self-center pl-1 pr-1">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
            </div>
        @endif

        @if (site_setting('maintenance_enabled'))
            <div class="alert bg-danger text-center text-white">
                You are currently in maintenance mode. <a href="{{ route('maintenance.exit') }}" class="text-white" style="font-weight:600;">[Exit]</a>
            </div>
        @endif

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

        @if (!site_setting('catalog_purchases_enabled') && Str::startsWith(request()->route()->getName(), 'catalog.'))
            <div class="alert bg-warning text-center text-white" style="font-weight:600;">
                Market purchases are temporarily unavailable. Items may be browsed but are unable to be purchased.
            </div>
        @endif

        @yield('content')
</main>
  <footer class="container text-center mb-5 mt-5" style="padding-top:0;">
        <div class="mb-2" style="font-size:17px;">
            <a href="{{ route('info.index', 'terms') }}" class="text-muted mr-3" style="text-decoration:none;">TERMS</a>
            <a href="{{ route('info.index', 'privacy') }}" class="text-muted mr-3" style="text-decoration:none;">PRIVACY</a>
            <a href="{{ route('jobs.listings.index') }}" class="text-muted mr-3" style="text-decoration:none;" target="_blank">JOBS</a>
            <a href="{{ route('info.index', 'team') }}" class="text-muted" style="text-decoration:none;">TEAM</a>
        </div>

        <div><strong>Copyright &copy; {{ config('site.name') }} {{ date('Y') }}</strong>.</div>

        @if (config('site.socials.discord') || config('site.socials.twitter'))
            <div class="mt-2">
                @if (config('site.socials.discord'))
                    <a href="{{ config('site.socials.discord') }}" style="color:#7289da;font-size:25px;text-decoration:none;" title="Join our Discord server!" target="_blank" data-toggle="tooltip">
                        <i class="fab fa-discord"></i>
                    </a>
                @endif

                @if (config('site.socials.twitter'))
                    <a href="{{ config('site.socials.twitter') }}" style="color:#00acee;font-size:26px;text-decoration:none;" title="Follow us on Twitter!" target="_blank" data-toggle="tooltip">
                        <i class="fab fa-twitter-square"></i>
                    </a>
                @endif
            </div>
        @endif
    </footer>
  
 <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        var _token;

        $(() => {
            _token = $('meta[name="csrf-token"]').attr('content');

            $('[data-toggle="tooltip"]').tooltip();

            $('#sidebarToggler').click(function() {
                const enabled = !$('.sidebar').hasClass('show');

                if (enabled)
                    $('.sidebar').addClass('show');
                else
                    $('.sidebar').removeClass('show');
            });
        });
    </script>
    <script src="{{ asset('js/search.js') }}"></script>
    @yield('js')
  </body> 
</html>