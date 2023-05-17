@extends('layouts.admin', [
    'title' => "View Job Response from \"{$response->applicant->username}\""
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.jobs.responses.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $response->id }}">
                <div class="row">
                    <div class="col-md-2"><strong>Applicant</strong></div>
                    <div class="col-md-10"><a href="{{ route('users.profile', $response->applicant->username) }}" target="_blank">{{ $response->applicant->username }}</a></div>
                    @if ($response->status != 'pending')
                        <div class="col-md-2"><strong>Reviewer</strong></div>
                        <div class="col-md-10"><a href="{{ route('users.profile', $response->reviewer->username) }}" target="_blank">{{ $response->reviewer->username }}</a></div>
                    @endif
                    <div class="col-md-2"><strong>Status</strong></div>
                    <div class="col-md-10 {{ $response->class }}"><strong>{{ ucfirst($response->status) }}</strong></div>
                    <div class="col-md-2"><strong>Name</strong></div>
                    <div class="col-md-10">{{ $response->name }}</div>
                    <div class="col-md-2"><strong>Email Address</strong></div>
                    <div class="col-md-10">{{ $response->email }}</div>
                    <div class="col-md-12 mt-4"><strong>Why do you want to work at {{ config('site.name') }}?</strong></div>
                    <div class="col-md-12">{!! nl2br(e($response->why_work)) !!}</div>
                    <div class="col-md-12 mt-4"><strong>Why should we choose you?</strong></div>
                    <div class="col-md-12">{!! nl2br(e($response->why_choose)) !!}</div>
                    <div class="col-md-12 mt-4"><strong>How did you find {{ config('site.name') }}?</strong></div>
                    <div class="col-md-12 mb-4">{!! nl2br(e($response->how_find)) !!}</div>
                    @if ($response->status == 'pending')
                        <div class="col-6">
                            <button class="btn btn-block btn-success" name="action" value="accept"><i class="fas fa-check"></i></button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-block btn-danger" name="action" value="decline"><i class="fas fa-times"></i></button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
