@extends('layouts.default', [
    'title' => $title
])

@section('content')
    <div class="row">
        <div class="col">
            <h3>{{ $title }}</h3>
        </div>
        @if ($document == 'team')
            <div class="col text-right">
                <a href="{{ route('jobs.listings.index') }}" class="btn btn-success" target="_blank"><i class="fas fa-plus"></i> Join</a>
            </div>
        @endif
    </div>
    <div class="card">
        <div class="card-body">
            @include("web.info._{$view}", $variables)
        </div>
    </div>
@endsection
