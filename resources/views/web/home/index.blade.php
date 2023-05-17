@extends('layouts.default', [
    'title' => 'Welcome'
])

@section('content')
    <p>This page is currently being updated.</p>
    <p>For now click <a href="{{ route('auth.register.index') }}">here</a> to create an account.</p>
@endsection
