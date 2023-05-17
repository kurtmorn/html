@extends('layouts.admin', [
    'title' => 'New Job Listing'
])

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.jobs.listings.create') }}" method="POST">
                @csrf
                <label for="title">Title</label>
                <input class="form-control mb-2" type="text" name="title" placeholder="Title" required>
                <label for="category">Category</label>
                <input class="form-control mb-2" type="text" name="category" placeholder="Category" required>
                <label for="body">Body (supports HTML)</label>
                <textarea class="form-control mb-2" name="body" placeholder="Write listing body here..." rows="15" required></textarea>
                <button class="btn btn-block btn-success" type="submit">Create</button>
            </form>
        </div>
    </div>
@endsection
