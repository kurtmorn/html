@extends('layouts.admin', [
    'title' => "Edit \"{$listing->title}\""
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.jobs.listings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="uid" value="{{ $listing->uid }}">
                <input type="hidden" name="action" value="update">
                <label for="title">Title</label>
                <input class="form-control mb-2" type="text" name="title" placeholder="Title" value="{{ $listing->title }}" required>
                <label for="category">Category</label>
                <input class="form-control mb-2" type="text" name="category" placeholder="Category" value="{{ $listing->category }}" required>
                <label for="body">Body (supports HTML)</label>
                <textarea class="form-control mb-2" name="body" placeholder="Write listing body here..." rows="15" required>{{ $listing->body }}</textarea>
                <button class="btn btn-block btn-success" type="submit">Edit</button>
            </form>
        </div>
    </div>
@endsection
