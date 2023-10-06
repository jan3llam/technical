@extends('layouts.layout')

@section('vendors')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col">
                <h2>Blog List</h2>
            </div>
            <div class="col-auto">
                <a href="{{ route('blogs.create') }}" class="btn btn-primary">Create New Blog</a>
            </div>
        </div>
        <form action="{{ route('blogs.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by Title"
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <table id="blogsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Publish Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $blog)
                    <tr data-blog-id="{{ $blog->id }}">
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->publish_date }}</td>
                        <td>{{ ucfirst($blog->status) }}</td>
                        <td>
                            <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-info btn-sm">Show</a>
                            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm delete-blog"
                                data-blog-id="{{ $blog->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $blogs->links() }}
    </div>
@endsection


@section('scripts')
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/tables/table-datatables-advanced.js')) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#blogsTable').DataTable({});
        });
    </script>
    <script>
        $(document).ready(function() {

            $('.delete-blog').click(function() {
                const blogId = $(this).data('blog-id');
                if (confirm('Are you sure you want to delete this blog?')) {
                    const accessToken = localStorage.getItem('access_token');
                    axios.delete("{{ url('blogs') }}/" + blogId, {
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Authorization': `Bearer ${accessToken}`,
                            },
                        })
                        .then(function(response) {
                            alert(response.data.message);
                            $('#blogsTable').DataTable().row($('tr[data-blog-id="' + blogId + '"]'))
                                .remove().draw();
                        })
                        .catch(function(error) {
                            console.error('Error deleting blog:', error);
                        });
                }
            });
        });
    </script>
@endsection
