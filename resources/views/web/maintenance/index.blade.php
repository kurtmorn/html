@extends('layouts.css', [
    'title' => 'Maintenance'
])

@section('content')
<!DOCTYPE html>
<html>
<head>
  <title>Site Maintenance</title>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
</head>
<style>
  body { 
    text-align: center; 
    padding: 150px; 
  }
  h1 { 
    font-size: 50px; 
    color:#969696;
  }
  body {
   font-family: 'Lato', sans-serif; 
   color: #333; 
   background-color: #141414;
   margin-top:-50px;
 }
 article { 
  display: block; 
  text-align: center; 
  width: 650px; 
  margin: 0 auto; 
}
a { color: #c9ac3a; 
  text-decoration: none; 
}
a:hover { 
  color: #333; 
  text-decoration: none; 
}
body::-webkit-scrollbar {
  width: 0.4em;
}

body::-webkit-scrollbar-track {
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
}

body::-webkit-scrollbar-thumb {
  background-color: darkgrey;
}


.icon {
  -webkit-animation: blinkYellow 1.2s infinite;
  -moz-animation: blinkYellow 1.2s infinite;
  -ms-animation: blinkYellow 1.2s infinite;
  -o-animation: blinkYellow 1.2s infinite;
  animation: blinkYellow 1.2s infinite;
}

@-webkit-keyframes blinkYellow {
  from {}
  50% {}
  to { opacity:0; }
}
.powerButton{
  width: 100%;
  text-align: center;
}
.message{
  color:#969696 !important;
}
.team{
  font-weight: bold;
  color:#969696 !important;
}


</style>

<article>
  <div class="powerButton">
    <i class="fa fa-power-off icon" style="color:#969696;font-size:120pt;" ></i>
  </div>
  <h1>We&rsquo;ll be back soon!</h1>
  <div>
    <p class="message">We&rsquo;re performing some maintenance at the moment.</p>
    <br>
  </div>
      @if (count($errors) > 0)
        <div class="alert bg-danger text-white">
            @foreach ($errors->all() as $error)
                <div>{!! $error !!}</div>
            @endforeach
        </div>
    @endif
    <form action="{{ route('maintenance.authenticate') }}" method="POST">
        @csrf
        <div class="input-group">
            <input class="form-control" type="password" name="password" placeholder="Developer Password">
            <div class="input-group-append">
                <button class="btn btn-success" type="submit">Login</button>
            </div>
        </div>
    </form>
    @if (config('site.socials.discord') || config('site.socials.twitter'))
            <div class="mt-2">
                @if (config('site.socials.discord'))
                    <a href="{{ config('site.socials.discord') }}" style="color:#7289da;font-size:40px;text-decoration:none;" title="Join our Discord server!" target="_blank" data-toggle="tooltip">
                        <i class="fab fa-discord"></i>
                    </a>
                @endif

                @if (config('site.socials.twitter'))
                    <a href="{{ config('site.socials.twitter') }}" style="color:#00acee;font-size:43px;text-decoration:none;" title="Follow us on Twitter!" target="_blank" data-toggle="tooltip">
                        <i class="fab fa-twitter-square"></i>
                    </a>
                @endif
            </div>
        @endif
</article>
</html>
@endsection
