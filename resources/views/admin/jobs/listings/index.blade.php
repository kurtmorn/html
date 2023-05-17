@extends('layouts.admin', [
    'title' => 'Manage Job Listings'
])

@section('header')
    <a href="{{ route('admin.jobs.listings.new') }}" class="btn btn-success"><i class="fas fa-plus"></i></a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li class="nav-item">
                    <a href="{{ route('admin.jobs.listings.index', 'active') }}" class="nav-link @if ($category == 'active') active @endif">Active</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.jobs.listings.index', 'inactive') }}" class="nav-link @if ($category == 'inactive') active @endif">Inactive</a>
                </li>
            </ul>
        </div>
    </div>
    @if ($listings->count() == 0)
        <p>No job listings were found.</p>
    @else
        <div class="card" style="border:0;">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listings as $listing)
                        <tr>
                            <td><a href="{{ route('admin.jobs.listings.edit', $listing->uid) }}">{{ $listing->id }}</a></td>
                            <td><a href="{{ route('admin.jobs.listings.edit', $listing->uid) }}">{{ $listing->title }}</a></td>
                            <td>{{ $listing->created_at }}</td>
                            <td>
                                <form action="{{ route('admin.jobs.listings.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="uid" value="{{ $listing->uid }}">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <button class="btn btn-sm btn-{{ ($listing->is_active) ? 'danger' : 'success' }}" type="submit"><i class="fas fa-{{ ($listing->is_active) ? 'trash' : 'eye' }}"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $listings->onEachSide(1) }}
    @endif
@endsection
