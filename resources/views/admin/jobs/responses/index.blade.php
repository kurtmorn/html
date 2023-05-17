@extends('layouts.admin', [
    'title' => 'Manage Job Responses'
])

@section('content')
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li class="nav-item">
                    <a href="{{ route('admin.jobs.responses.index', 'pending') }}" class="nav-link @if ($category == 'pending') active @endif">Pending</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.jobs.responses.index', 'declined') }}" class="nav-link @if ($category == 'declined') active @endif">Declined</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.jobs.responses.index', 'accepted') }}" class="nav-link @if ($category == 'accepted') active @endif">Accepted</a>
                </li>
            </ul>
        </div>
    </div>
    @if ($responses->count() == 0)
        <p>No job responses were found.</p>
    @else
        <div class="card" style="border:0;">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Position</th>
                        <th>Created</th>
                        <th>Applicant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($responses as $response)
                        <tr>
                            <td><a href="{{ route('admin.jobs.responses.view', $response->id) }}">{{ $response->id }}</a></td>
                            <td><a href="{{ route('admin.jobs.responses.view', $response->id) }}">{{ $response->listing->title }}</a></td>
                            <td>{{ $response->created_at }}</td>
                            <td><a href="{{ route('users.profile', $response->applicant->username) }}">{{ $response->applicant->username }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $responses->onEachSide(1) }}
    @endif
@endsection
