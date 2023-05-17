@extends('layouts.jobs', [
    'title' => 'Listings'
])

@section('css')
    <style>
        .listing:not(:first-child) {
            padding-top: 16px;
        }

        .listing:not(:last-child) {
            padding-bottom: 16px;
            border-bottom: 1px solid #0000001a;
        }
    </style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3><i class="fas fa-list mr-1" style="font-size:25px;"></i> Listings</h3>
            <div class="card text-center-sm">
                <div class="card-body">
                    @forelse ($listings as $listing)
                        <div class="listing">
                            <div class="row">
                                <div class="col-md-10 align-self-center">
                                    <h4>{{ $listing->title }}</h4>
                                    <p><strong>{{ $listing->category }}</strong></p>
                                </div>
                                <div class="col-md-2 align-self-center">
                                    <div class="mt-3 show-sm-only"></div>
                                    <a href="{{ route('jobs.listings.view', $listing->uid) }}" class="btn btn-block btn-outline-success">View</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>There are currently no available listings. Check again later!</p>
                    @endforelse
                </div>
            </div>
            {{ $listings->onEachSide(1) }}
        </div>
    </div>
@endsection
