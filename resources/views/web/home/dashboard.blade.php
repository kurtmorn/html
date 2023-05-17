@extends('layouts.default', [
    'title' => 'Dashboard'
])

@section('css')
    <style>
        img.user-headshot {
            background: var(--headshot_bg);
            border-radius: 50%;
        }

        .update {
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .update:not(:last-child) {
            border-bottom: 1px solid var(--divider_color);
        }

        @media only screen and (max-width: 768px) {
            img.user-headshot {
                width: 40%;
                margin-bottom: 16px
            }
        }
    </style>
@endsection

@section('content')
<h3>Dashboard</h3>
		<div class="row">
			<div class="col-md-4 col-lg-3">
				<div class="card text-center">
					<div class="card-body">
						<img src="{{ Auth::user()->thumbnail() }}" width="90%">
					</div>
				</div>
              <button class="btn btn-success btn-block">Invite Friends</button>
              <br>
            <h3>Updates</h3>
            <div class="card">
                <div class="card-body" @if ($updates->count() > 0) style="padding-top:0;padding-bottom:0;" @endif>
                    @forelse ($updates as $update)
                        <div class="update">
                            <div class="text-truncate"><a href="{{ route('forum.thread', $update->id) }}" style="color:inherit;font-weight:600;">{{ $update->title }}</a></div>
                            <div class="text-muted text-truncate">by <a href="{{ route('users.profile', $update->creator->username) }}">{{ $update->creator->username }}</a> {{ $update->created_at->diffForHumans() }}</div>
                        </div>
                    @empty
                        <p>No updates found.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-8 col-lg-9">
            <div class="card">
                <div class="card-body">
                            <form action="{{ route('home.status') }}" method="POST">
                                @csrf
                                <div class="input-group">
                                <input class="form-control" name="message" placeholder="Hi there, my name is {{ Auth::user()->username }}!">
                                <div class="input-group-append">
                                <button class="btn btn-success" type="submit">Update</button>
                                </div>
                              </div>
                            </form>
                    </div>
                </div>   
   <div class="card">
		<div class="card-body">
       @forelse ($statuses as $status)
          <div class="row has-divider py-16">
								<div class="col-4 col-md-3 col-lg-2 text-center">
									<a href="{{ route('users.profile', $status->creator->username) }}">
										<img class="user-headshot" src="{{ $status->creator->headshot() }}">
									</a>
								</div>
								<div class="col-8 col-md-9 col-lg-10 align-self-center">
									<div>
										<a href="{{ route('users.profile', $status->creator->username) }}" style="font-size:18px;">{{ $status->creator->username }}</a>
										<span class="text-muted ml-2" style="font-size:12px;"><i class="fas fa-clock" style="font-size:10px;"></i> 15 minutes ago</span>
										<a href="/report" class="float-right text-danger"><i class="fad fa-flag"></i></a>
									</div>
									<div class="mb-2">{{ $status->message }}</div>
								</div>
							</div>
          @empty
          <h5 class="mt-16">Your feed is empty.</h5>
						<div class="mb-16">Why not try <a href="/users">searching for users</a> or <a href="/discussions">chatting with users</a> on the discussions tab?</div> 

          @endforelse
    </div>
   </div>
</div>      
@endsection
