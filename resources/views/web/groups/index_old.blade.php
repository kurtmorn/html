@extends('layouts.default', [
    'title' => 'Spaces'
])

@section('content')
    <div class="row mb-1">
        <div class="col">
            <h3>Spaces</h3>
        </div>
        <div class="col text-right">
            <a href="{{ route('creator_area.index', ['t' => 'group']) }}" class="btn btn-success"><i class="fas fa-plus"></i> Create</a>
        </div>
    </div>
    <form action="{{ route('groups.index') }}" method="GET">
        <div class="input-group mb-3">
            <input class="form-control" type="text" name="search" placeholder="Search for spaces..." value="{{ request()->search }}">
            <div class="input-group-append">
                <button class="btn btn-success" type="submit">
                    <i class="fas fa-search"></i>
                    <span class="hide-sm">Search</span>
                </button>
            </div>
        </div>
    </form>
    @forelse ($groups as $group)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4 col-md-2">
                        <a href="{{ route('groups.view', [$group->id, $group->slug()]) }}">
                            <img src="{{ $group->thumbnail() }}" style="background:var(--section_bg_inside);border-radius:6px;">
                        </a>
                    </div>
                    <div class="col-8 col-md-8 align-self-center">
                        <h5 class="text-truncate"><a href="{{ route('groups.view', [$group->id, $group->slug()]) }}" style="color:inherit;font-weight:600;">{{ $group->name }}</a></h5>
                        <div class="text-muted show-sm-only" style="margin-top:-5px;">{{ number_format($group->members()->count()) }} Members</div>
                        <div style="max-height:125px;overflow:hidden;">{{ $group->description ?? 'This space does not have a description.' }}</div>
                    </div>
                    <div class="col-md-2 text-center align-self-center hide-sm" style="font-weight:600;">
                        <h3>{{ number_format($group->member_count) }}</h3>
                        <h4 class="text-muted" style="margin-top:-10px;margin-bottom:0;">MEMBERS</h4>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p>No spaces found.</p>
    @endforelse
    {{ $groups->onEachSide(1) }}
@endsection
