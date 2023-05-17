@extends('layouts.default', [
    'title' => 'Users'
])

@section('css')
    <style>
        img.user-headshot {
            background: var(--headshot_bg);
            border-radius: 50%;
            margin: 0 auto;
            display: block;
        }

        @media only screen and (min-width: 768px) {
            img.user-headshot {
                width: 60%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col-3"><h3>Users</h3></div>
                <div class="col-9 text-right mt-1"><strong>{{ number_format($total) }} Total Users</strong></div>
            </div>
            <form action="{{ route('users.index') }}" method="GET">
                <input class="form-control mb-3" type="text" name="search" placeholder="Search..." value="{{ request()->search }}">
            </form>
            @if (!empty($search))
                <div class="row">
                    @forelse ($users as $user)
                        <div class="col-6 col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <a href="{{ route('users.profile', $user->username) }}" style="color:inherit;font-weight:600;">
                                        <img class="user-headshot" src="{{ $user->headshot() }}">
                                        <div class="text-truncate mt-1">{{ $user->username }}</div>
                                    </a>
                                    <div class="text-{{ ($user->online()) ? 'success' : 'muted' }}">{{ ($user->online()) ? 'Online' : 'Offline' }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col">No users have been found.</div>
                    @endforelse
                </div>
                {{ $users->onEachSide(1) }}
            @endif
        </div>
    </div>
@endsection
