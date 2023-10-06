@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>Edit Subscriber</h2>
        @foreach ($errors->all() as $error)
            <li class="text-danger">{{ $error }}</li>
        @endforeach
        <form action="{{ route('subscribers.update', $subscriber->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $subscriber->name }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                    value="{{ $subscriber->username }}" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="active" @if ($subscriber->status === 'active') selected @endif>Active</option>
                    <option value="inactive" @if ($subscriber->status === 'inactive') selected @endif>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
