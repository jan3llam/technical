@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>Edit Blog</h2>
        @foreach ($errors->all() as $error)
            <li class="text-danger">{{ $error }}</li>
        @endforeach
        <form id="blogForm" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $blog->title }}" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="4" required>{{ $blog->content }}</textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="published" @if ($blog->status == 'published') selected @endif>Published</option>
                    <option value="draft" @if ($blog->status == 'draft') selected @endif>Draft</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="publish_date" class="form-label">Publish Date</label>
                <input type="date" class="form-control" id="publish_date" name="publish_date"
                    value="{{ $blog->publish_date }}" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="submitForm()">Save</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function submitForm() {
            const formData = new FormData(document.getElementById('blogForm'));
            const accessToken = localStorage.getItem('access_token');
            axios.post("{{ route('blogs.update', $blog->id) }}", formData, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'multipart/form-data',
                        'Authorization': `Bearer ${accessToken}`,
                    },
                })
                .then(function(response) {
                    alert(response.data.message);
                })
                .catch(function(error) {
                    alert(error.response.data.message);
                });
        }
    </script>
@endsection
