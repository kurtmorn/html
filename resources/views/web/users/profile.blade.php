@extends('layouts.default', [
    'title' => "{$user->username}'s Profile",
    'image' => $user->headshot()
])

@section('meta')
    <meta name="item-types-with-padding" content="{{ json_encode(config('site.item_thumbnails_with_padding')) }}">
    <meta name="item-type-padding-amount" content="{{ itemTypePadding('default') }}">
    <meta name="user-info" data-id="{{ $user->id }}" data-inventory-public="{{ $user->setting->public_inventory }}">
@endsection

@section('css')
    <style>
        .card-body {
            padding: 15px;
        }
        .status {
            border-radius: 0px 0px 2px 2px;
            height: 7px;
        }
        .description {
            max-height: 300px;
            overflow-y:auto;
        }
        @media  only screen and (min-width: 768px) {
            .personal-status {
                margin-top: 31px;
            }
        }
        .friend-status {
            border-radius: 50%;
            width: 8px;
            height: 8px;
            display: inline-block;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('js/profile.js?v=4') }}"></script>
@endsection

@section('content')
<div class="row">
<div class="col-md-3">
<h5>
<span>{{ $user->username }}</span>
@if ($user->is_verified)
                                    <i class="fas fa-shield-check text-success ml-1" style="font-size:16px;" title="This user is verified." data-toggle="tooltip"></i>
                                @endif

                                @if ($user->usernameHistory()->count() > 0)
                                    <i class="fal fa-info-circle text-muted ml-1" style="font-size:16px;" title="Previous Usernames: {{ $user->usernameHistoryString() }}" data-toggle="tooltip"></i>
                                @endif
  
</h5>
@if ($user->status())
<div class="card personal-status show-sm-only">
<div class="card-body">
<strong>Personal Status:</strong>
<span>{{ $user->status() }}</span>
</div>
</div>
@endif  
<div class="card">
<div class="card-body">
<img src="{{ $user->thumbnail() }}">
</div>
<div class="status bg-{{ ($user->online()) ? 'success' : 'muted' }}" title="{{ $user->username }} is {{ ($user->online()) ? 'online' : 'offline' }}" data-toggle="tooltip"></div>
</div>
 @if ($user->isBanned())
        <div class="alert bg-danger text-white text-center">
            <span>This user is banned.</span>
        </div>
    @endif
                            @if (Auth::check() && $user->id != Auth::user()->id)
                                <div class="row mt-3">
                                    @if ($user->setting->accepts_messages)
                                        <div class="col">
                                            <a href="{{ route('account.inbox.new', ['message', $user->username]) }}" class="btn btn-block btn-primary"><i class="fas fa-envelope"></i></a>
                                        </div>
                                    @endif

                                    @if ($areFriends || $isPending || $user->setting->accepts_friends)
                                        <div class="col">
                                            @if ($areFriends)
                                                <form action="{{ route('account.friends.update') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                                    <input type="hidden" name="action" value="remove">
                                                    <button class="btn btn-block btn-danger"><i class="fas fa-user-times"></i></button>
                                                </form>
                                            @elseif ($isPending)
                                                <button class="btn btn-block btn-secondary" disabled><i class="fas fa-clock"></i></button>
                                            @elseif ($user->setting->accepts_friends)
                                                <form action="{{ route('account.friends.update') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                                    <input type="hidden" name="action" value="send">
                                                    <button class="btn btn-block btn-success"><i class="fas fa-user-plus"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif

                                    @if ($user->setting->accepts_trades && !$user->isBanned())
                                        <div class="col">
                                            <a href="{{ route('account.trades.send', $user->username) }}" class="btn btn-block btn-warning"><i class="fas fa-exchange"></i></a>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff('can_view_user_info'))
                                <a href="{{ route('admin.users.view', $user->id) }}" class="btn btn-block btn-danger mt-2" target="_blank"><i class="fas fa-gavel"></i> View in Panel</a>
                            @endif
<br>
<h5>Description</h5>
<div class="card description">
<div class="card-body">
{{ $user->description }}
</div>
</div>  
<div class="card">
<div class="card-body">
<div class="row">
<div class="col-6"><strong>Joined:</strong></div>
<div class="col-6 text-right">{{ $user->created_at->format('M d, Y') }}</div>
<div class="col-6"><strong>Friends:</strong></div>
<div class="col-6 text-right">{{ number_format($user->friends()->count()) }}</div>
<div class="col-6"><strong>Posts:</strong></div>
<div class="col-6 text-right">{{ number_format($user->forumPostCount()) }}</div>
</div>
</div>
</div>
</div>
<div class="col-md-9">
@if ($user->status())
<div class="card personal-status hide-sm">
<div class="card-body">
<strong>Personal Status:</strong>
<span>{{ $user->status() }}</span>
</div>
</div>
@endif
@if (!empty($user->badges()))  
<h5>Badges</h5>
<div class="card">
<div class="card-body" style="padding-bottom:0;">
<div class="row">
@foreach ($user->badges() as $badge)  
<div class="col-6 col-md-2 text-center mb-3">
<a href="{{ route('badges.index') }}" style="color:inherit;text-decoration:none;">
<img src="{{ $badge->image }}">
<div class="text-truncate" style="font-size:14px;">{{ $badge->name }}</div>
</a>
</div>
@endforeach  
</div>
</div>
</div>
@endif  
<div class="row">
<div class="col-auto">
<h5>Friends</h5>
</div>
<div class="col text-right">
<a href="{{ route('users.friends', $user->username) }}" class="btn btn-sm btn-success">View All</a>
</div>
</div>
<div class="card">
<div class="card-body" @if ($friends->count() > 0) style="padding-bottom:0;" @endif>
<div class="row">
  @forelse ($friends as $friend)
<div class="col-6 col-md-2 text-center mb-2">
<a href="{{ route('users.profile', $friend->username) }}" style="color:inherit;text-decoration:none;">
<img src="{{ $friend->thumbnail() }}">
<div class="text-truncate" style="font-size:14px;margin-top:5px;">
<div class="friend-status bg-{{ ($friend->online()) ? 'success' : 'muted' }}" title="{{ $friend->username }} is {{ ($friend->online()) ? 'online' : 'offline' }}" data-toggle="tooltip"></div>
<span>{{ $friend->username }}</span>
</div>
</a>
</div>
@empty
                            <div class="col text-center">
                                <i class="fas fa-frown text-warning mb-2" style="font-size:50px;"></i>
                                <div>This user has no friends.</div>
                            </div>
                        @endforelse
</div>
</div>
</div>
<div class="row">
<div class="col-auto">
<h5>Spaces</h5>
</div>
<div class="col text-right">
<a href="{{ route('users.groups', $user->username) }}" class="btn btn-sm btn-success">View All</a>
</div>
</div>
<div class="card">
<div class="card-body" @if ($groups->count() > 0) style="padding-bottom:0;" @endif>
<div class="row">
@forelse ($groups as $group)  
<div class="col-6 col-md-2 text-center mb-2">
<a href="{{ route('groups.view', [$group->id, $group->slug()]) }}" style="color:inherit;text-decoration:none;">
<img src="{{ $group->thumbnail() }}">
<div class="text-truncate" style="font-size:14px;margin-top:5px;">Vextoria</div>
</a>
</div>
@empty
                            <div class="col text-center">
                                <i class="fas fa-frown text-warning mb-2" style="font-size:50px;"></i>
                                <div>This user is not in any spaces.</div>
                            </div>
                        @endforelse
</div>
</div>
</div>
@if ($user->setting->public_inventory)  
<h5>Inventory</h5>
<div class="card">
<div class="card-body">
<div class="row">
<div class="col-md-2">
<ul class="nav nav-pills nav-justified flex-column flex-row" role="tablist">
  @foreach (config('site.inventory_item_types') as $type)
  <li class="nav-item">
    <span class="nav-link flex-fill text-left @if ($type == 'hat') active @endif" data-category="{{ lcfirst(itemType($type, true)) }}">{{ itemType($type, true) }}</span>
  </li>
  @endforeach
</ul>
<div class="mb-2 show-sm-only"></div>
</div>
<div class="col-md-10">
<div class="row" id="inventory"></div>
</div>
</div>
</div>
</div>
@endif
</div>
</div>
@endsection
