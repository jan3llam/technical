@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h5>{{ $blog->title }}</h5>
        </div>
        <div class="card-body">
            <img src="{{ url('uploads/blogs/' . $blog->image) }}" alt="{{ $blog->title }}" class="img-fluid mb-3">
            <p>{{ $blog->content }}</p>
            <p><strong>Status:</strong> {{ ucfirst($blog->status) }}</p>
            <p><strong>Publish Date:</strong> {{ $blog->publish_date }}</p>
        </div>
    </div>
</div>
@endsection
